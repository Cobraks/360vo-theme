// =====================================================
// Global Variables
// =====================================================
// Ya no usamos jQuery

// Variable global para controlar el estado del TOC
let isTocToggling = false;

// =====================================================
// Función: Inicializar popup del footer
// =====================================================
function initBotonFlotanteContacto() {
	const popup = document.getElementById("popup");
	const openBtn = document.getElementById("open-popup");
	const closeBtn = document.getElementById("close-popup");

	if (popup && openBtn && closeBtn) {
		openBtn.addEventListener("click", () => {
			popup.style.display = "flex";
			console.log("abierto");
		});

		closeBtn.addEventListener("click", () => {
			popup.style.display = "none";
			console.log("cerrado");
		});

		window.addEventListener("click", (event) => {
			if (event.target === popup) {
				popup.style.display = "none";
				console.log("cerrado");
			}
		});
	}
}

// =====================================================
// Función: Inicializar loader del mapa con fallback
// =====================================================
function initFooterMapLoader() {
	const placeholder = document.querySelector(".map-placeholder");
	const iframe = document.getElementById("mapFrame");
	if (!placeholder || !iframe) return;

	let loaded = false;
	iframe.addEventListener("load", () => {
		loaded = true;
		placeholder.classList.add("loaded");
		iframe.classList.add("loaded");
	});

	// Fallback: si en 5s no se ha disparado load
	setTimeout(() => {
		if (!loaded) {
			placeholder.classList.add("loaded");
			iframe.classList.add("loaded");
		}
	}, 5000);
}

// =====================================================
// Función: Animación de botones en el pie de página
// =====================================================
function initializeFooterButtonAnimations() {
	const wrapper = document.querySelector(".button--footer-wrapper");
	const buttons = document.querySelectorAll(".button--footer");

	function checkWrapperVisibility() {
		if (!wrapper) return;
		const rect = wrapper.getBoundingClientRect();

		if (rect.top < window.innerHeight && rect.bottom >= 0) {
			buttons.forEach((button, index) => {
				button.style.transitionDelay = `${index * 0.15}s`;
				button.classList.add("animate-in");
			});
		} else {
			buttons.forEach((button) => {
				button.classList.remove("animate-in");
			});
		}
	}

	window.addEventListener("scroll", checkWrapperVisibility);
	window.addEventListener("resize", checkWrapperVisibility);

	// Inicializar en carga
	checkWrapperVisibility();
}

// =====================================================
// Función: Eliminar clases ocultas con retraso
// =====================================================
function removeHiddenClassWithDelay() {
	setTimeout(() => {
		document.querySelectorAll(".mobile-nav").forEach((el) => {
			el.classList.remove("initially-hidden");
		});
	}, 100);
}

// =====================================================
// Función: Manejo del menú de navegación móvil
// =====================================================
function initializeMobileMenu() {
	const toggles = document.querySelectorAll(".menu-button, .menu-button-line");
	const closeBtns = document.querySelectorAll(
		".close-button, .close-button-line"
	);
	const backdrop = document.querySelector(".backdrop");
	const mobileNav = document.querySelector(".mobile-nav");
	const body = document.body;

	toggles.forEach((btn) =>
		btn.addEventListener("click", () => {
			mobileNav?.classList.add("open");
			backdrop?.classList.add("open");
			document
				.querySelectorAll(".menu-button, .close-button")
				.forEach((el) => el.classList.add("open"));
			body.classList.add("no-scroll");
		})
	);

	closeBtns.forEach((btn) =>
		btn.addEventListener("click", () => {
			mobileNav?.classList.remove("open");
			backdrop?.classList.remove("open");
			document
				.querySelectorAll(".menu-button, .close-button")
				.forEach((el) => el.classList.remove("open"));
			body.classList.remove("no-scroll");
		})
	);

	backdrop?.addEventListener("click", (event) => {
		if (
			mobileNav &&
			!mobileNav.contains(event.target) &&
			!Array.from(toggles).some((t) => t.contains(event.target))
		) {
			mobileNav.classList.remove("open");
			backdrop.classList.remove("open");
			body.classList.remove("no-scroll");
		}
	});
}

// =====================================================
// Función: Alternar clases dinámicas para usuarios logueados al hacer scroll
// =====================================================
function toggleScrolledLoggedIn() {
	const scrollY = window.scrollY;
	const targets = document.querySelectorAll(
		"header, aside.buscador, nav.nav-breadcrumb, nav.mobile-nav, .ordenar_por"
	);

	if (document.body.classList.contains("logged-in")) {
		targets.forEach((el) => {
			if (scrollY > 0) el.classList.add("scrolled_logged-in");
			else el.classList.remove("scrolled_logged-in");
		});
	} else {
		const header = document.querySelector("header");
		if (!header) return;
		if (scrollY > 0) header.classList.add("scrolled");
		else header.classList.remove("scrolled");
	}
}

// =====================================================
// Función: Manejo del scroll y visibilidad dinámica de elementos
// =====================================================
function handleScrollBehavior() {
	let lastScrollTop = 0;
	let lastScrollPos = 0;

	window.addEventListener("scroll", () => {
		if (isTocToggling) return;
		toggleScrolledLoggedIn();

		const st = window.scrollY;
		if (st > lastScrollTop && st > lastScrollPos + 1) {
			document.querySelector(".nav-breadcrumb")?.classList.add("hidden");
			document
				.querySelector("aside.buscador")
				?.classList.add("hidden-breadcrumb");
			document.body.classList.add("hidden");
			lastScrollPos = st;
		} else if (st < lastScrollPos - 1) {
			document.querySelector(".nav-breadcrumb")?.classList.remove("hidden");
			document
				.querySelector("aside.buscador")
				?.classList.remove("hidden-breadcrumb");
			document.body.classList.remove("hidden");
			lastScrollPos = st;
		}
		lastScrollTop = Math.max(0, st);
	});
}

// =====================================================
// Función: Inicializar la Tabla de Contenidos (TOC)
// =====================================================
function initializeTableOfContents() {
	const tocContainer = document.querySelector(".toc-container__content");
	const tocContainerElement = document.getElementById("toc-container");
	if (!tocContainer || !tocContainerElement) return;

	const content = document.querySelector(".custom-page__content");
	if (!content) return;

	// Recogemos todos los encabezados h2–h6, salvo los dentro de .vehicle-card__container
	const allHeadings = Array.from(
		content.querySelectorAll("h2, h3, h4, h5, h6")
	).filter((h) => !h.closest(".vehicle-card__container"));

	if (allHeadings.length) {
		document.querySelector(".toc-container__toggle")?.classList.add("show");
	}

	// Generar el HTML
	let tocHtml = "<ul class='toc__list'>";
	let idCounter = 0;
	let headingNumbers = [0, 0, 0, 0, 0];
	const idPrefix = "toc-heading-";

	allHeadings.forEach((heading) => {
		const level = parseInt(heading.tagName[1]) - 2; // h2→0, h3→1...
		headingNumbers[level]++;
		// Reset posteriores
		for (let i = level + 1; i < headingNumbers.length; i++)
			headingNumbers[i] = 0;

		const headingNumber = headingNumbers.slice(0, level + 1).join(".");
		const id = heading.id || idPrefix + idCounter++;
		heading.id = id;

		const itemClass =
			level === 1 ? "toc__item toc__item--subitem" : "toc__item";

		tocHtml +=
			`<li class="${itemClass}">` +
			`<a href="#${id}" class="toc__link">` +
			`<span class="toc__number">${headingNumber}.</span> ` +
			`${heading.textContent}` +
			`</a>` +
			`</li>`;
	});
	tocHtml += "</ul>";
	tocContainer.innerHTML = tocHtml;

	// Manejar clics en enlaces
	tocContainer.querySelectorAll(".toc__link").forEach((link) => {
		link.addEventListener("click", (event) => {
			event.preventDefault();
			const target = document.querySelector(link.getAttribute("href"));
			if (target) {
				window.scrollTo({
					top: target.getBoundingClientRect().top + window.scrollY - 200,
					behavior: "smooth",
				});
			}
			// Actualizar clases activas
			tocContainer
				.querySelectorAll(".toc__item")
				.forEach((li) => li.classList.remove("active"));
			link.parentElement.classList.add("active");
			allHeadings.forEach((h) => h.classList.remove("active"));
			target?.classList.add("active");

			// Cerrar TOC si está abierto
			if (tocContainer.classList.contains("show")) {
				setTimeout(() => {
					tocContainer.classList.remove("show");
					tocContainerElement.classList.remove("open");
					document.querySelectorAll(".backdrop").forEach((b) => {
						b.classList.remove("open");
						b.style.zIndex = "";
					});
					const toggleText = document.querySelector(
						".toc-container__toggle .toc-container__text"
					);
					if (toggleText) {
						toggleText.textContent = "Mostrar tabla de contenidos";
					}
				}, 1000);
			}
		});
	});

	// Toggle TOC
	document
		.querySelector(".toc-container__toggle")
		?.addEventListener("click", () => {
			if (isTocToggling) return;
			isTocToggling = true;

			tocContainer.classList.toggle("show");
			tocContainerElement.classList.toggle("open");
			document
				.querySelectorAll(".backdrop")
				.forEach((b) => b.classList.toggle("open"));

			if (tocContainerElement.classList.contains("open")) {
				document
					.querySelectorAll(".backdrop")
					.forEach((b) => (b.style.zIndex = "97"));
				const toggleText = document.querySelector(
					".toc-container__toggle .toc-container__text"
				);
				if (toggleText) {
					toggleText.textContent = "Ocultar tabla de contenidos";
				}
				tocContainer.querySelectorAll(".toc__item").forEach((item, idx) => {
					setTimeout(() => item.classList.add("show"), 50 / (idx + 1));
				});
			} else {
				document
					.querySelectorAll(".backdrop")
					.forEach((b) => (b.style.zIndex = ""));
				const toggleText = document.querySelector(
					".toc-container__toggle .toc-container__text"
				);
				if (toggleText) {
					toggleText.textContent = "Mostrar tabla de contenidos";
				}
				tocContainer
					.querySelectorAll(".toc__item")
					.forEach((item) => item.classList.remove("show"));
			}

			setTimeout(() => {
				isTocToggling = false;
			}, 300);
		});

	// Hacerlo sticky y detectar final de contenedor
	const initialTop = tocContainerElement.offsetTop;
	window.addEventListener("scroll", () => {
		const headerHeight =
			document.querySelector(".site-header")?.offsetHeight || 0;
		const scrollPos = window.scrollY;
		const parentRect =
			tocContainerElement.parentElement.getBoundingClientRect();
		const tocRect = tocContainerElement.getBoundingClientRect();

		if (scrollPos > initialTop - headerHeight - 20) {
			tocContainerElement.classList.add("sticky");
		} else {
			tocContainerElement.classList.remove("sticky");
		}

		if (tocRect.bottom > parentRect.bottom) {
			tocContainerElement.classList.add("end-of-container");
			tocContainer.classList.remove("show");
			tocContainerElement.classList.remove("open");
			document.querySelectorAll(".backdrop").forEach((b) => {
				b.classList.remove("open");
				b.style.zIndex = "";
			});
			const toggleText = document.querySelector(
				".toc-container__toggle .toc-container__text"
			);
			if (toggleText) {
				toggleText.textContent = "Mostrar tabla de contenidos";
			}
		} else {
			tocContainerElement.classList.remove("end-ofcontainer");
		}
	});
}

// =====================================================
// Función: Inicializar el botón de copiar enlace
// =====================================================
function initializeCopyButton() {
	const copyButton = document.getElementById("copy-button");
	const copyButtonText = document.querySelector(".share__button-text");

	if (copyButton && copyButtonText) {
		copyButton.addEventListener("click", () => {
			const tempInput = document.createElement("input");
			tempInput.value = window.location.href;
			document.body.appendChild(tempInput);
			tempInput.select();
			document.execCommand("copy");
			document.body.removeChild(tempInput);

			copyButtonText.textContent = "¡Link copiado!";
			copyButton.disabled = true;

			setTimeout(() => {
				copyButtonText.textContent = "Copiar enlace";
				copyButton.disabled = false;
			}, 3000);
		});
	}
}

// =====================================================
// Función: Inicializar el botón de compartir
// =====================================================
function initializeShareButton() {
	const shareButton = document.getElementById("share-button");
	if (!shareButton) return;

	shareButton.addEventListener("click", () => {
		if (navigator.share) {
			navigator
				.share({
					title: document.title,
					text: "¡Mira este contenido increíble!",
					url: window.location.href,
				})
				.catch(console.error);
		} else {
			console.log("La Web Share API no está soportada en este navegador.");
		}
	});
}

// =====================================================
// Función: Inicializar los botones de scroll en las migas de pan (breadcrumbs)
// =====================================================
function setupScrollButtons() {
	const leftBtnContainer = document.querySelector(".btn-container--left");
	const rightBtnContainer = document.querySelector(".btn-container--right");
	const leftBtn = document.querySelector(".left-btn");
	const rightBtn = document.querySelector(".right-btn");
	const breadcrumb = document.getElementById("breadcrumb");

	if (!breadcrumb) return;

	leftBtnContainer.style.display = "none";
	rightBtnContainer.style.display = "none";

	function updateButtonVisibility() {
		const isOverflowing = breadcrumb.scrollWidth > breadcrumb.clientWidth;
		const links = breadcrumb.querySelectorAll("a");

		if (isOverflowing) {
			rightBtnContainer.style.display = "flex";
			leftBtnContainer.style.display =
				breadcrumb.scrollLeft > 0 ? "flex" : "none";
			if (
				breadcrumb.scrollLeft + breadcrumb.clientWidth >=
				breadcrumb.scrollWidth
			) {
				rightBtnContainer.style.display = "none";
			}
		} else {
			leftBtnContainer.style.display = "none";
			rightBtnContainer.style.display = "none";
		}

		if (breadcrumb.scrollLeft === 0) {
			links.forEach((link) => link.classList.add("disable-click"));
			setTimeout(() => {
				links.forEach((link) => link.classList.remove("disable-click"));
			}, 2000);
		}
	}

	leftBtn?.addEventListener("click", () => {
		breadcrumb.scrollBy({ left: -100, behavior: "smooth" });
		updateButtonVisibility();
	});

	rightBtn?.addEventListener("click", () => {
		breadcrumb.scrollBy({ left: 100, behavior: "smooth" });
		updateButtonVisibility();
	});

	breadcrumb.addEventListener("scroll", updateButtonVisibility);
	window.addEventListener("resize", updateButtonVisibility);

	updateButtonVisibility();
}

// =====================================================
// Inicialización de funciones en DOMContentLoaded
// =====================================================
document.addEventListener("DOMContentLoaded", () => {
	initBotonFlotanteContacto();
	initFooterMapLoader();
	setupScrollButtons();

	// Animaciones y menús
	initializeFooterButtonAnimations();
	removeHiddenClassWithDelay();
	initializeMobileMenu();
	handleScrollBehavior();
	toggleScrolledLoggedIn();

	// TOC
	initializeTableOfContents();

	// Compartir/copiar
	initializeCopyButton();
	initializeShareButton();
});
