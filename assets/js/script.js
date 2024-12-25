document.addEventListener("contextmenu", (event) => event.preventDefault());

function setTheme(mode) {
  const themeIcon = document.querySelector(".theme-icon");
  const themeText = document.querySelector(".theme-text");

  if (mode === "auto") {
    const prefersDark = window.matchMedia(
      "(prefers-color-scheme: dark)"
    ).matches;
    document.documentElement.setAttribute(
      "data-theme",
      prefersDark ? "dark" : "light"
    );
    themeIcon.textContent = "🌓";
    themeText.textContent = "خودکار";
  } else if (mode === "light") {
    document.documentElement.setAttribute("data-theme", "light");
    themeIcon.textContent = "🌞";
    themeText.textContent = "روشن";
  } else if (mode === "dark") {
    document.documentElement.setAttribute("data-theme", "dark");
    themeIcon.textContent = "🌙";
    themeText.textContent = "تاریک";
  }

  localStorage.setItem("theme", mode);
}

const savedTheme = localStorage.getItem("theme") || "auto";
setTheme(savedTheme);

document.querySelectorAll(".dropdown-menu li").forEach((item) => {
  item.addEventListener("click", () => {
    const selectedMode = item.getAttribute("data-mode");
    setTheme(selectedMode);
  });
});

function scrollFunction() {
  const header = document.getElementById("header");
  const isScrolled =
    document.body.scrollTop > 30 || document.documentElement.scrollTop > 30;

  const isNarrowScreen = window.innerWidth < 1080;

  const styles = isScrolled
    ? {
        width: "100%",
        height: "80px",
        top: "0",
        borderRadius: "0",
        border: "none",
        borderBottom: "2px solid var(--bg3-color)",
        background: "var(--bg2-blur)",
      }
    : {
        width: isNarrowScreen ? "90%" : "85%",
        height: "90px",
        top: "20px",
        borderRadius: "20px",
        border: "none",
        background: "var(--bg2-color)",
      };

  Object.assign(header.style, styles);
}

function copyToClipboard(text) {
  if (
    navigator.clipboard &&
    typeof navigator.clipboard.writeText === "function"
  ) {
    navigator.clipboard
      .writeText(text)
      .then(() => {
        showCopyPopup();
      })
      .catch((err) => {
        alert("Failed to copy the link. Please try again.");
      });
  } else {
    const textarea = document.createElement("textarea");

    textarea.value = text;
    textarea.style.position = "fixed";
    textarea.style.opacity = "0";
    document.body.appendChild(textarea);
    textarea.select();

    try {
      document.execCommand("copy");
      showCopyPopup();
    } catch (err) {
      alert("Failed to copy the link. Please try again.");
    }
    document.body.removeChild(textarea);
  }
}

function showCopyPopup() {
  const popup = document.getElementById("copy-popup");
  popup.classList.add("show");
  setTimeout(() => {
    popup.classList.remove("show");
  }, 2000);
}

const swiper = new Swiper(".swiper", {
  direction: "horizontal",
  loop: true,
  lazy: true,
  allowTouchMove: true,

  keyboard: {
    enabled: true,
  },

  autoplay: {
    delay: 1500,
  },

  breakpoints: {
    300: {
      slidesPerView: 1,
    },
    720: {
      slidesPerView: 2,
      navigation: false,
    },
    1150: {
      slidesPerView: 3,
    },
    1450: {
      slidesPerView: 4,
    },
  },

  slidesPerView: 3,
  spaceBetween: 20,
});

document.addEventListener("DOMContentLoaded", () => {
  const body = document.getElementsByTagName("body")[0];
  const menuIcon = document.getElementById("menu-icon");
  const sidebar = document.getElementById("sidebar");
  const closeSidebar = document.getElementById("close-sidebar");

  menuIcon.addEventListener("click", () => {
    sidebar.style.right = "0";
    body.classList.add("no-scroll");
  });

  closeSidebar.addEventListener("click", () => {
    sidebar.style.right = "-1080px";
    body.classList.remove("no-scroll");
  });
});

window.onscroll = function () {
  scrollFunction();
  blogProgress();
};

function blogProgress() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height =
    document.documentElement.scrollHeight -
    document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
}
