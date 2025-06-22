const headerTemplate = document.createElement('template');

headerContent = `
<style>
  header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 0.75rem 1rem;
    background: #ffccff;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    z-index: 99;
    box-sizing: border-box;
  }

  .logo {
    font-size: 2em;
    color: #ffffff;
    user-select: none;
    font-family: Agbalumo, sans-serif;
    flex-shrink: 0;
  }

  .nav-auth-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    align-items: center;
    justify-content: flex-end;
    flex-grow: 1;
  }

  .navigation {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    justify-content: flex-end;
    align-items: center;
  }

  .navigation a {
    font-family: Poppins, sans-serif;
    position: relative;
    font-size: 1.1em;
    color: #ffffff;
    text-decoration: none;
    font-weight: 1000;
  }

  .navigation a::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 100%;
    height: 3px;
    background: #fff;
    border-radius: 5px;
    transform-origin: right;
    transform: scaleX(0);
    transition: transform 0.5s;
  }

  .navigation a:hover::after {
    transform-origin: left;
    transform: scaleX(1);
  }

  .auth-links {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
  }

  .auth-links button {
    padding: 0.4rem 0.9rem;
    font-family: Poppins, sans-serif;
    font-size: 0.9rem;
    border: none;
    border-radius: 1rem;
    background-color: #ffffff;
    color: #ff69b4;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  @media screen and (max-width: 720px) {
    header {
      flex-direction: column;
      align-items: stretch;
    }

    .nav-auth-wrapper {
      flex-direction: column;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .navigation {
      justify-content: flex-start;
    }

    .auth-links {
      justify-content: flex-start;
    }
  }
</style>

<header>
  <h2 class="logo">Regnum Jeb</h2>
  <div class="nav-auth-wrapper">
    <nav class="navigation">
      <a href="/">Home</a>
      <a href="/about/">About</a>
      <a href="/contact/">Contact</a>
      <a href="/forum/">Forum</a>
      <a href="/profile/">Profile</a>
    </nav>
    <div class="auth-links">
      <button id="openLoginBtn">Login</button>
      <button id="openRegisterBtn">Register</button>
    </div>
  </div>
</header>
`;

headerTemplate.innerHTML = headerContent;

class Header extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const shadowRoot = this.attachShadow({ mode: 'open' }); // ← IMPORTANT: now open!
    shadowRoot.appendChild(headerTemplate.content);
  }
}

customElements.define('header-component', Header);