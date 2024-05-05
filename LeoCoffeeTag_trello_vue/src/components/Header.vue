<template>
  <div class="navbar">
    <a href="#home">Home</a>
    <a href="#news">News</a>

    <div class="dropdown">
      <button class="dropbtn">Área de Trabalho</button>

      <div class="dropdown-content">
        <a href="#link1">Link 1</a>
        <a href="#link2">Link 2</a>
        <a href="#link3">Link 3</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropbtn">Recentes</button>

      <div class="dropdown-content">
        <a href="#link1">Link 1</a>
        <a href="#link2">Link 2</a>
        <a href="#link3">Link 3</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropbtn">Criar</button>

      <div class="dropdown-content">
        <a href="#link1">Link 1</a>
        <a href="#link2">Link 2</a>
        <a href="#link3">Link 3</a>
      </div>
    </div>

    <div id="busca">
      <form action="#" class="search" method="get">
        <input id="txtBusca" name="q" type="text" placeholder="Digite o que você procura" />
        <input id="btnBusca" type="submit" value="Ok" />
        <input id="btnSair" type="button" value="Sair" />
      </form>
    </div>
  </div>

  <header class="header"></header>
</template>

<style scoped>
.navbar {
  overflow: hidden;
  background-color: #333;
  font-family: Arial;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover,
.dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

#busca {
  margin: 10px;
  padding: 10px;
  float: right;
}

#txtBusca {
  border: 0px solid #222;
  background: #eee;
  width: 260px;
  height: 32px;
  margin: 0 auto;
  padding: 5px 0 5px 5px;
  float: left;
  line-height: 36px;
}

#btnBusca {
  background: #00cccc;
  position: relative;
  border: 0px solid #222;
  color: #fff;
  margin: 0 auto;
  padding: 10px;
  height: 32px;
  border: 0 none;
  font-size: 11px;
  font-weight: bold;
  text-transform: uppercase;
}

#btnSair {
  background: #c24d49;
  position: relative;
  border: 0px solid #222;
  color: #fff;
  margin: 0px 20px;
  padding: 10px;
  height: 32px;
  border: 0 none;
  font-size: 11px;
  font-weight: bold;
  text-transform: uppercase;
}

#btnBusca:hover,
#btnSair:hover {
  background: red;
  cursor: pointer;
}

.header {
  width: 100%;
  background: var(--color-blue);
  height: 3.5rem;
}
</style>
