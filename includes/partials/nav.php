<?php
// Shared site navigation. Pages that have their own contact form set
// $navContactHref = '#contact' before including this file; everywhere
// else the Contact link goes to the homepage form.
$navContactHref = $navContactHref ?? 'index.php#contact';
?>
<!--Beginning of navigation section-->
  <div class="nav-bar">
      <div class="nav-bar__left">
          <a href="index.php" class="nav-bar-brand">
              <img src="assets/main_img.png" alt="Nurture Impact Logo" class="nav-bar-brand__img">
          </a>
          <div class="nav-bar__title">
              <span class="nav-bar__title-text">Nurture Impact</span>
          </div>
      </div>
      <ul class="nav-bar__links">
        <li><a href="index.php">Home</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="projects.php">Projects</a></li>
        <li><a href="insights.php">Insights</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="<?php echo htmlspecialchars($navContactHref, ENT_QUOTES, 'UTF-8'); ?>">Contact</a></li>
      </ul>
      <a href="#main-content" class="skip-to-main">skip to main content</a>
  </div>
    <div class="navigation">
      <input type="checkbox" class="navigation__checkbox" id="navi-toggle" aria-hidden="true">
      <label for="navi-toggle" class="navigation__button">
        <span class="navigation__icon">&nbsp;</span>
      </label>
      <div class="navigation__background">&nbsp;</div>
      <nav class="navigation__nav">
        <ul class="navigation__list">
          <li class="navigation__item"><a href="index.php" class="navigation__link">HOME</a></li>
          <li class="navigation__item"><a href="services.php" class="navigation__link">SERVICES</a></li>
          <li class="navigation__item"><a href="projects.php" class="navigation__link">PROJECTS</a></li>
          <li class="navigation__item"><a href="insights.php" class="navigation__link">INSIGHTS</a></li>
          <li class="navigation__item"><a href="about.php" class="navigation__link">ABOUT</a></li>
          <li class="navigation__item"><a href="<?php echo htmlspecialchars($navContactHref, ENT_QUOTES, 'UTF-8'); ?>" class="navigation__link">CONTACT</a></li>
        </ul>
      </nav>
    </div>
    <!--End of navigation section-->
