const URL = "http://192.168.56.10:8080/search?";

const output = document.querySelector("#output");

const fetchPhotos = async e => {
  const query = e.target.value;
  if (!query) {
    output.innerHTML = "";
    return;
  }

  const res = await fetch(URL + new URLSearchParams({ query }));
  output.innerHTML = await res.text();
};

document
  .querySelector("input[name=query]")
  .addEventListener("keyup", fetchPhotos);
