<form action="/favourites" method="POST" id="photosForm">
  <header>
    <h1>Formula One Gallery</h1>
    <button>Remember selected</button>
  </header>
  <div class="no-results">Showing <?= count($photos) ?> of <?= $total ?> results</div>
  <div class="photosContainer">
    <?php foreach ($photos as $photo) : ?>
      <div class="photo">
        <?php if ($photo->privateOwner !== null) : ?>
          <div class="privateIcon" title="Private">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" />
              <path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z" />
              <path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" />
            </svg>
          </div>
        <?php endif; ?>

        <div class="description">
          <span class="author"><?= $photo->author ?></span>
          <span class="title"><?= $photo->title ?></span>
        </div>

        <input type="checkbox" class="favourite" name="favourite[]" value="<?= $photo->getId() ?>" id="<?= $photo->getId() ?>" <?= $photo->isFavourite() ? "checked disabled" : "" ?>>
        <label for="<?= $photo->getId() ?>" class="favouriteLabel">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="solid-star">
            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="outline-star">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
          </svg>
        </label>

        <a href="/photos/<?= $photo->getId() ?>">
          <img src="<?= $photo->getThumbnailPath() ?>" />
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</form>
<footer>
  <?php if ($page > 1) : ?>
    <a href="/photos?page=<?= $page - 1 ?>">Previous</a>
  <?php else : ?>
    <span>Previous</span>
  <?php endif; ?>
  <span class="page"><?= $page ?></span>
  <?php if ($page * $pageSize < $total) : ?>
    <a href="/photos?page=<?= $page + 1 ?>">Next</a>
  <?php else : ?>
    <span>Next</span>
  <?php endif; ?>
</footer>
