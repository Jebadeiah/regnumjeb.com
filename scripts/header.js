const headerTemplate = document.createElement('template');

headerContent = `
<style>
  header	{
    position: 			fixed;
    top:				    0;
    left:	 		    	0;
    width:		      100%;
    padding-left:   20px;
    padding-right:  20px;
    background:		  #ffccff;
    display:			  flex;
    justify-content:space-between;
    align-items:		center;
    z-index:		  	99;
  }

  .navigation a 	{
    font-family:  Poppins, sans-serif;
    position:			    relative;
    font-size:			  1.1em;
    color:				    #ffffff;
    text-decoration: 	none;
    font-weight: 		  1000;
    margin: 		      0 60px;
    box-sizing:       border-box;
    float:            right;
  }

  .navigation a::after	{
    content:     	    '';
    position: 			  absolute;
    left:				      0;
    bottom: 			    -6px;
    width:				    100%;
    height:				    3px;
    background:       #fff;
    border-radius: 		5px;
    transform-origin:	right;
    transform: 		  	scaleX(0);
    transition:			  transform .5s;
  }
  
  .navigation a:hover::after 	{
    transform-origin: 	left;
    transform:			    scaleX(1);
  }
      
  .logo	{
    font-size: 		  2em;
    color: 			    #ffffff;
    user-select: 	  none;
    font-family: 	  Agbalumo, sans-serif;
    float:          left;
  }
  
  .btnLogin-popup{
    width: 20%;
    height: 45px;
    border: none;
    outline: none;
    border-radius: 6px;
    cursor: pointer;
    font-family: Agbalumo, sans-serif;
    font-size: 1.5em;
    text-decoration: bold;
    background-color: transparent;
    color: #fff;
    font-weight: 500;
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}

  @media screen and (min-width:720px) {
    width: 100%
  }

  @media screen and (min-width:450px) and (max-width:719px) {
    .navigation {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      column-gap: 20px;
    }
  }

  @media screen and (min-width:370px) and (max-width:449px) {
    header {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      column-gap: 20px;
    }
    .navigation {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      column-gap: 20px;
    }
  }
  
  @media screen and (max-width:369px) {
    header {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      column-gap: 20px;
    }
    .navigation {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      column-gap: 20px;
    }
  }

</style>
<header>
  <h2 class="logo">Regnum Jeb</h2> <!--
  <button class="btnLogin-popup">Enter the Realm!</button>
  <nav class="navigation">
    <a href="/profile/">Profile</a>
    <a href="/forum/">Forum</a>
    <a href="/contact/">Contact</a>
    <a href="/about/">About</a>
    <a href="/">Home</a>
  </nav> -->
</header>
`;

headerTemplate.innerHTML = headerContent;

class Header extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    const shadowRoot = this.attachShadow({ mode: 'closed' });

    shadowRoot.appendChild(headerTemplate.content);
  }
}

customElements.define('header-component', Header);