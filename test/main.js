let list = document.querySelectorAll(".navbar li");

function activeLink() {
    list.forEach(item=>{
        item.classList.remove("hovered")});
    this.classList.add("hovered")
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

let toggle = document.querySelector(".toggle");
let navbar = document.querySelector(".navbar");
let main = document.querySelector(".main");
let subMenu = document.getElementById("subMenu");
let topbar = document.querySelector(".topbar")

function menu(){
    subMenu.classList.toggle("open-menu");
}

toggle.onclick = function(){
    navbar.classList.toggle("active");
    main.classList.toggle("active");
    topbar.classList.toggle("active")
};

document.getElementById('loadData').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah default action dari link
    fetch('api.php')
        .then(response => response.json())
        .then(data => {
            const contentDiv = document.getElementById('content');
            contentDiv.innerHTML = ''; // Clear previous content

            data.forEach(item => {
                const p = document.createElement('p');
                p.textContent = `ID: ${item.id}, Name: ${item.name}`;
                contentDiv.appendChild(p);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});