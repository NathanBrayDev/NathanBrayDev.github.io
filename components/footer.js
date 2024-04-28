class Footer extends HTMLElement {
    constructor() {
      super();
    }
  
    connectedCallback() {
      this.innerHTML = `
<footer>
<ul>
  <li><a href="/index">Home</a></li>
  <li><a href="/contact" class="active">Skills</a></li>
  <li><a href="/projects">Projects</a></li>
  <li><a href="/aboutMe">About me</a></li>
  <li><a href="mailto:nathanbray.dev@gmail.com">&#9993;</a></li>
  <li><a href="https://www.linkedin.com/in/nathan-bray-5067a5168/">in</a></li>
</ul>
</footer>
`;
}
}

customElements.define('footer-component', Footer);