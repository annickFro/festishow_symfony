const descriptions = document.querySelectorAll(".card .description p");

for (const description of descriptions) {
  if (description.innerHTML.length > 150) {
    description.innerHTML = description.innerHTML
      .slice(0, 150)
      .concat(" [...]");
  }
}
