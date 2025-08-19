document.addEventListener("DOMContentLoaded", () => {
	/* ------------------------------------------------------------------
     1. Función de scroll para el botón (usa 72px de offset)
  ------------------------------------------------------------------ */
	const initScrollButton = () => {
		const button = document.getElementById("scrollButton");
		if (button) {
			button.addEventListener("click", () => {
				const target = document.querySelector(".recent-cars");
				if (target) {
					const headerHeight = 72; // Valor fijo del header
					const targetPosition =
						target.getBoundingClientRect().top +
						window.pageYOffset -
						headerHeight;
					smoothScrollTo(window.pageYOffset, targetPosition, 800);
				}
			});
		}
	};

	const smoothScrollTo = (start, end, duration) => {
		const startTime = performance.now();
		const scroll = () => {
			const now = performance.now();
			const time = Math.min(1, (now - startTime) / duration);
			// Easing ease-out
			const easedTime = time * (2 - time);
			window.scrollTo(0, Math.ceil(easedTime * (end - start) + start));
			if (time < 1) {
				requestAnimationFrame(scroll);
			}
		};
		requestAnimationFrame(scroll);
	};

	/* ------------------------------------------------------------------
     2. Función para gestionar el banner de Complianz (clic en .test)
  ------------------------------------------------------------------ */
	const initComplianzBanner = () => {
		document.querySelectorAll(".test").forEach((element) => {
			element.addEventListener("click", (e) => {
				e.preventDefault();
				document.querySelectorAll(".cmplz-manage-consent").forEach((btn) => {
					btn.click();
				});
			});
		});
	};

	/* ------------------------------------------------------------------
     3. Funcionalidad del Carousel
  ------------------------------------------------------------------ */
	const initCarousel = () => {
		const track = document.querySelector(".carousel__track");
		if (!track) return;
		const nextButton = document.querySelector(".carousel__button--next");
		const prevButton = document.querySelector(".carousel__button--prev");
		const carousel = track.closest(".carousel");

		// Determinar columnas visibles según viewport.
		const getVisibleColumns = () => {
			if (window.innerWidth >= 1900) return 4;
			if (window.innerWidth >= 1024) return 3;
			if (window.innerWidth >= 768) return 2;
			return 1;
		};

		// Comprueba la carga de la imagen y añade un spinner.
		const checkImageLoad = (slide) => {
			const carCard = slide.querySelector(".car-card");
			const img = slide.querySelector(".car-card__image");
			if (!img.complete) {
				carCard.classList.add("loading");
				img.addEventListener("load", () => carCard.classList.remove("loading"));
				img.addEventListener("error", () =>
					carCard.classList.remove("loading")
				);
			}
		};

		// Clonamos slides para efecto infinito.
		const slidesOriginal = Array.from(track.children);
		const originalCount = slidesOriginal.length;

		const cloneSlidesAll = () => {
			track.querySelectorAll(".clone").forEach((clone) => clone.remove());
			// Clonar hacia atrás (en orden inverso)
			[...slidesOriginal].reverse().forEach((slide) => {
				const clone = slide.cloneNode(true);
				clone.classList.add("clone");
				track.prepend(clone);
			});
			// Clonar hacia adelante (en orden normal)
			slidesOriginal.forEach((slide) => {
				const clone = slide.cloneNode(true);
				clone.classList.add("clone");
				track.appendChild(clone);
			});
		};

		cloneSlidesAll();
		let slides = Array.from(track.children);
		slides.forEach(checkImageLoad);

		// Posicionar slides de acuerdo a su ancho y al gap definido en CSS.
		const setSlidePositions = () => {
			const slideWidth = slides[0].getBoundingClientRect().width;
			const gap = parseFloat(getComputedStyle(track).gap) || 0;
			slides.forEach((slide, index) => {
				slide.style.left = `${(slideWidth + gap) * index}px`;
			});
			return { slideWidth, gap };
		};

		let { slideWidth, gap } = setSlidePositions();
		let currentIndex = originalCount; // Iniciamos en el primer slide original

		const setTransform = (index) => {
			track.style.transform = `translate3d(-${
				index * (slideWidth + gap)
			}px, 0, 0)`;
		};
		setTransform(currentIndex);

		// Función para asignar un "índice lógico" a cada slide.
		const getLogicalIndex = (i) => {
			if (i < originalCount) return (originalCount - 1 - i) % originalCount;
			if (i < 2 * originalCount) return (i - originalCount) % originalCount;
			return (i - 2 * originalCount) % originalCount;
		};

		// Actualiza la clase "active" en función del índice lógico y columnas visibles.
		const updateActiveSlides = (index) => {
			const currentLogical = getLogicalIndex(index);
			const columns = getVisibleColumns();
			const activeLogicalIndices = Array.from(
				{ length: columns },
				(_, j) => (currentLogical + j + originalCount) % originalCount
			);
			slides.forEach((slide, i) => {
				const logical = getLogicalIndex(i);
				if (activeLogicalIndices.includes(logical)) {
					slide.classList.add("active");
				} else {
					slide.classList.remove("active");
				}
			});
			if (index === originalCount) {
				slides[originalCount - 1].classList.remove("active");
			}
		};

		updateActiveSlides(currentIndex);

		// Evitar transiciones simultáneas.
		let isAnimating = false;
		const moveToSlide = (newIndex) => {
			if (isAnimating) return;
			isAnimating = true;
			track.style.transition =
				"transform 0.4s cubic-bezier(0.25, 0.1, 0.25, 1)";
			currentIndex = newIndex;
			setTransform(currentIndex);
			updateActiveSlides(currentIndex);
		};

		track.addEventListener("transitionend", (e) => {
			if (e.propertyName !== "transform" || !isAnimating) return;
			let needsReset = false;
			if (currentIndex >= 2 * originalCount) {
				currentIndex -= originalCount;
				needsReset = true;
			} else if (currentIndex < originalCount) {
				currentIndex += originalCount;
				needsReset = true;
			}
			if (needsReset) {
				track.style.transition = "none";
				track.classList.add("no-transition");
				setTransform(currentIndex);
				updateActiveSlides(currentIndex);
				void track.offsetWidth; // Forzar reflow
				track.classList.remove("no-transition");
				isAnimating = false;
			}
			isAnimating = false;
		});

		if (nextButton) {
			nextButton.addEventListener("click", () => moveToSlide(currentIndex + 1));
		}
		if (prevButton) {
			prevButton.addEventListener("click", () => moveToSlide(currentIndex - 1));
		}

		// Autoplay
		let autoPlayInterval = setInterval(
			() => moveToSlide(currentIndex + 1),
			3000
		);
		carousel.addEventListener("mouseenter", () =>
			clearInterval(autoPlayInterval)
		);
		carousel.addEventListener("mouseleave", () => {
			autoPlayInterval = setInterval(() => moveToSlide(currentIndex + 1), 3000);
		});

		// Swipe táctil
		let touchStartX = 0;
		track.addEventListener("touchstart", (e) => {
			touchStartX = e.touches[0].clientX;
		});
		track.addEventListener("touchend", (e) => {
			const diff = touchStartX - e.changedTouches[0].clientX;
			if (Math.abs(diff) > 50) {
				diff > 0
					? moveToSlide(currentIndex + 1)
					: moveToSlide(currentIndex - 1);
			}
		});

		// Debounce en resize
		const debounce = (func, wait) => {
			let timeout;
			return (...args) => {
				clearTimeout(timeout);
				timeout = setTimeout(() => func.apply(this, args), wait);
			};
		};

		window.addEventListener(
			"resize",
			debounce(() => {
				const activeSlideIndex = currentIndex - originalCount;
				const pos = setSlidePositions();
				slideWidth = pos.slideWidth;
				gap = pos.gap;
				currentIndex = originalCount + activeSlideIndex;
				track.style.transition = "none";
				setTransform(currentIndex);
				updateActiveSlides(currentIndex);
				track.style.transition = "";
			}, 100)
		);
	};

	/* ------------------------------------------------------------------
     Inicialización de todas las funciones
  ------------------------------------------------------------------ */
	initScrollButton();
	initComplianzBanner();
	initCarousel();
});
