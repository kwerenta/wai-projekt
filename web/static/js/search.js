const URL = `${window.location.origin}/search?`;

const output = document.querySelector("#output");

const fetchPhotos = async e => {
  const query = e.target.value;
  if (!query) {
    output.innerHTML = "";
    return;
  }

  try {
    const res = await fetch(URL + new URLSearchParams({ query }));
    output.innerHTML = await res.text();
  } catch (err) {
    output.innerHTML = "Error occured.";
  }

  if (output.innerHTML === "") output.innerHTML = "There are no results.";
};

const debouncedFetch = timeout => {
  let timer;
  return e => {
    clearTimeout(timer);
    timer = setTimeout(() => fetchPhotos(e), timeout);
  };
};

document
  .querySelector("input[name=query]")
  .addEventListener("keyup", debouncedFetch(300));
