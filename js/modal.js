document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("authModal");
  const card = document.getElementById("card");
  const pageContent = document.getElementById("pageContent");

  const registerForm = document.getElementById("registerForm");
  const loginForm = document.getElementById("loginForm");
  const cancelBtns = document.querySelectorAll(".cancel-btn");
  const flipToggles = document.querySelectorAll(".flip-toggle");

  const loginInner = loginForm.querySelector(".login-inner");

  const headerComponent = document.querySelector("header-component");
  let openLoginBtn, openRegisterBtn;

  if (headerComponent && headerComponent.shadowRoot) {
    openLoginBtn = headerComponent.shadowRoot.getElementById("openLoginBtn");
    openRegisterBtn = headerComponent.shadowRoot.getElementById("openRegisterBtn");
  }

  const showForm = (formName) => {
    if (formName === "register") {
      registerForm.classList.add("front-face");
      registerForm.classList.remove("back-face");
      loginForm.classList.add("back-face");
      loginForm.classList.remove("front-face");
      card.classList.remove("flipped");
      loginInner.classList.remove("fix-orientation");
    } else if (formName === "login") {
      loginForm.classList.add("front-face");
      loginForm.classList.remove("back-face");
      registerForm.classList.add("back-face");
      registerForm.classList.remove("front-face");
      card.classList.add("flipped");

      // Delay fixing mirrored text until after flip completes
      loginInner.classList.remove("fix-orientation");
      setTimeout(() => {
        loginInner.classList.add("fix-orientation");
      }, 600);
    } else {
        modal.style.display = "none";
    }
    registerForm.setAttribute("aria-hidden", formName !== "register");
    loginForm.setAttribute("aria-hidden", formName !== "login");

    modal.style.display = "flex";
    pageContent?.classList.add("blur");
  };

  openLoginBtn?.addEventListener("click", () => showForm("login"));
  openRegisterBtn?.addEventListener("click", () => showForm("register"));

  cancelBtns.forEach((btn) =>
    btn.addEventListener("click", () => {
      modal.style.display = "none";
      pageContent?.classList.remove("blur");
    })
  );

  flipToggles.forEach((btn) =>
    btn.addEventListener("click", () => {
      if (registerForm.classList.contains("front-face")) {
        showForm("login");
      } else {
        showForm("register");
      }
    })
  );

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
      pageContent?.classList.remove("blur");
    }
  });
});