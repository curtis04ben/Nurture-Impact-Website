<?php
// Shared contact form. Each page can override the wording by setting
// these variables before including this file; anything left unset falls
// back to the defaults below. $contactSource labels the enquiry email so
// it's clear which page the visitor wrote from.
$contactHeading     = $contactHeading     ?? 'Want to get in touch?';
$contactSub         = $contactSub         ?? 'Use the form below to get in touch with Nurture Impact';
$contactSource      = $contactSource      ?? 'Website';
$contactPlaceholder = $contactPlaceholder ?? 'Enter your message';
$contactSubmit      = $contactSubmit      ?? 'SEND MESSAGE';
$h = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
?>
    <!-- Contact section -->
    <section class="contact" id="contact">
      <h2 class="contact__heading" tabindex="0"><?php echo $h($contactHeading); ?></h2>
      <p class="contact__sub"><?php echo $h($contactSub); ?></p>
      <form id="contact-form" method="post" action="contact-handler.php">
        <input type="hidden" name="contact_number">
        <input type="hidden" name="source_page" value="<?php echo $h($contactSource); ?>">
        <input type="text" placeholder="Enter your name" id="name" name="from_name" aria-label="Enter your name" required>
        <input type="email" placeholder="Enter your email" id="email" name="reply_to" aria-label="Enter your email" required>
        <input type="text" placeholder="Organisation name (optional)" id="organisation" name="organisation" aria-label="Enter your organisation name">
        <textarea cols="30" rows="10" placeholder="<?php echo $h($contactPlaceholder); ?>" name="message" id="Message" aria-label="Enter your message" required></textarea>
        <input type="submit" class="btn" value="<?php echo $h($contactSubmit); ?>">
      </form>
    </section>
    <script src="assets/js/contact-form.js" defer></script>
