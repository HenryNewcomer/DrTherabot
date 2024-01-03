<?php
    $_POST['welcome_message'] = !empty($_POST['welcome_message']) ? $_POST['welcome_message'] : "[start]";
    require_once(__DIR__ . '/chat.php');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. Therabot :: Always free & always anonymous</title>
    <meta name="description" content="Dr. Therabot is a free, anonymous, and secure chatbot that can help you with your mental health.">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script async defer src="js/global.js"></script>
    <script async src="https://js.stripe.com/v3/buy-button.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue|Montserrat|Cormorant+Garamond|Material+Icons|Material+Symbols+Outlined">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="img/favicon-48x48.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon-180x180.png">
    <script>let fullConvo = [<?php echo "['system', '" . $_POST['welcome_message'] . "']"; ?>];</script>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-N67DE7J9GR"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-N67DE7J9GR');
</script>
<body>
    <header>
        <div class="loading" style="display: none">
            <div class="spinner">
                <div class="dot dot1"></div>
                <div class="dot dot2"></div>
                <div class="dot dot3"></div>
                <div class="dot dot4"></div>
                <div class="dot dot5"></div>
                <div class="dot dot6"></div>
                <div class="dot dot7"></div>
                <div class="dot dot8"></div>
            </div>
        <div class="errors"></div>
    </header>
    <main class="message_window">
        <div id="messages" tabindex="0"></div>
        <div class="your_message">
            <label class="header" for="prompt">Your message:</label>
            <div class="container">
                <form class="sender_input" id="sender_input">
                    <input type="text" id="newPrompt" name="newPrompt" placeholder="Go ahead :) Say 'hi'">
                </form>
                <div class="sender_button_container">
                    <?php if(isset($_GET['test-undo'])) {
                        echo '<button class="undo" id="undo"><i class="material-symbols-outlined">undo</i></button>';
                    } ?>
                    <button class="send_message" id="submit"><i class="material-icons">send</i></button>
                    <?php if(isset($_GET['test-mic'])) {
                        echo '<iframe class="record" src="speech.html" allow="microphone"></iframe>';
                    } ?>
                </div>
            </div>
        </div>
        <?php include_once(__DIR__ . '/tabs.php'); ?>
    </main>
    <footer>
        <div><a href="privacy.php" rel="noopener noreferrer" target="_blank">Privacy Policy</a> |
            <a href="https://status.openai.com/" rel="noopener noreferrer" target="_blank">OpenAI API Server Status</a></div>
        
        <div style="display: flex; justify-content: center; margin: 40px auto 0 auto;">
            <stripe-buy-button buy-button-id="buy_btn_1NFcleBClekrrtr0fmDH3Rht" publishable-key="pk_live_51NFRHgBClekrrtr0jP6bGKLoSznmMYF2ZaA8YliLyQAj1arhMir8zr6IvUCzUkORTxQlefWPkkAWJ1j3olQ3pZjJ00AxyutCA1"></stripe-buy-button>
        </div>
        <p>Contact:<br>
           dr.therabot@gmail.com</p>
        <p>Copyright &copy; Henry Newcomer 2023</p>
    </footer>
    <div id="cookie-banner">
        <p><em>We</em> don't save your data, but Google Analytics stores cookies on your computer. <a href="privacy.php">Learn more</a></p>
        <button id="accept-cookies">Accept</button>
    </div>
</body>
</html>