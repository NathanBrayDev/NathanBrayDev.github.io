class Header extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.innerHTML = `
      <header>
      <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
          <i class="fa fa-bars"></i>
        </label>
        <a href="/index"><label class="logo">Nathan Bray</label></a>
        <ul>
          <li><a class="nav" href="/index">Home</a></li>
          <li><a class="nav" href="/skills">Skills</a></li>
          <li><a class="nav" href="/projects">Projects</a></li>
          <li><a class="nav" href="/aboutMe">About me</a></li>
          <li><a class="nav" href="mailto:nathanbray.dev@gmail.com">&#9993;</a></li>
          <li><a class="nav" href="https://www.linkedin.com/in/nathan-bray-5067a5168/">in</a></li>
        </ul>
      </nav>
    </header>
    `;
  }
}

customElements.define('header-component', Header);