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
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>let fullConvo = [<?php echo "['system', '" . $_POST['welcome_message'] . "']"; ?>];</script>
    <script src="/js/global.js" async defer></script>
    <script async src="https://js.stripe.com/v3/buy-button.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue|Montserrat|Cormorant+Garamond|Material+Icons">
</head>
<body>
    <header>
        <div class="loading" style="display: none">Loading...</div>
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
                    <button class="send_message" id="submit"><i class="material-icons">send</i></button>
                </div>
            </div>
        </div>
        <?php include_once(__DIR__ . '/tabs.php'); ?>
    </main>
    <footer>
        <div style="display: flex; justify-content: center; margin: 40px auto 0 auto;">
            <stripe-buy-button buy-button-id="buy_btn_1NFT0yBClekrrtr0l4tmRsJO" publishable-key="pk_live_51NFRHgBClekrrtr0jP6bGKLoSznmMYF2ZaA8YliLyQAj1arhMir8zr6IvUCzUkORTxQlefWPkkAWJ1j3olQ3pZjJ00AxyutCA1"></stripe-buy-button>
        </div>
        <p>Copyright &copy; Henry Newcomer 2023</p>
    </footer>
</body>
</html>