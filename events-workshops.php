<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700|Great+Vibes:400,100,300,500,700' rel='stylesheet' type='text/css'>
  <title>Events &amp; Workshops | Nurture Impact</title>
  <meta name="description" content="Upcoming and past workshops, masterclasses and events from Nurture Impact, supporting organisations across the Youth & Community Development sector.">
  <link rel="canonical" href="https://www.nurtureimpact.ie/events-workshops.php">
  <meta property="og:title" content="Events & Workshops | Nurture Impact">
  <meta property="og:description" content="Upcoming and past workshops, masterclasses and events from Nurture Impact.">
  <meta property="og:type" content="website">
  <link rel="icon" type="image/png" href="assets/favicon-32.png" sizes="32x32">
  <link rel="apple-touch-icon" href="assets/favicon-180.png">
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <?php $navContactHref = '#contact'; include __DIR__ . '/includes/partials/nav.php'; ?>

  <header class="page-intro">
    <h1>Events &amp; Workshops</h1>
    <p>Upcoming and recent workshops, masterclasses and community sessions delivered by Nurture Impact.</p>
  </header>

  <main id="main-content">
    <section class="events" id="intro">
      <div class="events__container">
        <h2 class="events__heading">Upcoming Sessions</h2>
        <div class="events__cards">
          <!-- Example / placeholder event card. Once the content system (see /admin) is in
               use, upcoming events can be published here without editing this file. -->
          <div class="events__card">
            <div class="events__card-image">
              <img src="assets/governance.jpg" alt="Board members taking part in a governance session">
            </div>
            <div class="events__card-content">
              <span class="event-card__date">Date to be announced</span>
              <h3>Governance Essentials Workshop</h3>
              <p>An example placeholder listing. Real upcoming events will be published here once confirmed, without needing to edit this page directly.</p>
              <a href="#contact" class="events__btn">Register Interest</a>
            </div>
          </div>

          <div class="events__card">
            <div class="events__card-image">
              <img src="assets/funding_app.jpg" alt="Participant filling out a funding application">
            </div>
            <div class="events__card-content">
              <span class="event-card__date">Date to be announced</span>
              <h3>Funding &amp; Grant Applications Masterclass</h3>
              <p>An example placeholder listing for a future Pobal funding applications masterclass session.</p>
              <a href="#contact" class="events__btn">Register Interest</a>
            </div>
          </div>

          <div class="events__card">
            <div class="events__card-image">
              <img src="assets/workshop_1.jpg" alt="Team taking part in a board development session">
            </div>
            <div class="events__card-content">
              <span class="event-card__date">Date to be announced</span>
              <h3>Board Development Session</h3>
              <p>An example placeholder listing illustrating the layout used for bespoke board and team development sessions.</p>
              <a href="#contact" class="events__btn">Register Interest</a>
            </div>
          </div>
        </div>
        <p class="content-placeholder-note content-placeholder-note--on-dark">Sessions shown are illustrative placeholders. Get in touch to discuss tailored training and workshop dates for your organisation.</p>
      </div>
    </section>

    <section class="cta-section" id="cta">
      <div class="cta__wrapper">
        <h2 class="cta__headline">Looking for Tailored Training?</h2>
        <p class="cta__text">Nurture Impact can deliver bespoke workshops and training programmes for your organisation, team or board.</p>
        <div class="cta__buttons">
          <a href="services.php#training" class="why__cta-link">See Training &amp; Workshops</a>
        </div>
        <p class="cta__or">or</p>
        <a href="#contact" class="cta__contact-link">Get in touch directly</a>
      </div>
    </section>

    <?php
    $contactHeading = 'Interested in a Workshop?';
    $contactSub = 'Tell us about your organisation and training needs';
    $contactSource = 'Events & Workshops page';
    $contactPlaceholder = 'Tell us about the training or workshop you\'re interested in';
    $contactSubmit = 'SEND MESSAGE';
    include __DIR__ . '/includes/partials/contact-form.php';
    ?>
  </main>

  <?php include __DIR__ . '/includes/partials/footer.php'; ?>
</body>
</html>
