<?php
    # ssh: 9E.LEFaiF41O
    # gitHub Token: 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
    # mysql db: acliche1_lbllm
    # acliche1_henry
    # jS.%UZradg52JT,h9X 
    
    # Install:
    #  - composer (with autoloader.php)
    # composer require openai-php/client https://github.com/openai-php/client 
    # composer require guzzlehttp/guzzle 

    # TODOs:
    # - Rather than exit()s everywhere,
    #   shouldn't I be returning so the page doesn't stop loading the HTML?
    # - Add CSRF Token to forms.
    # - Add a better error handling system.
    # - Disable debug output on prod.

    session_start();

    include_once(__DIR__.'/chat.php');
    $_POST['welcome_message'] = !empty($_POST['welcome_message']) ? $_POST['welcome_message'] : "[start]"; // NOTE: This must be before /header.php's included.
    require_once(__DIR__.'/header.php'); // TODO: Don't forget that the title isn't dynamic at the moment!
?>
<?php include(__DIR__.'/reglog.php') ?>
<main class="message_window">

<div id="messages"></div>
<div class="your_message">
    <label class="header" for="prompt">Your message:</label>
    <div class="container">
        <form class="sender_input" id="sender_input">
            <input type="text" id="newPrompt" name="newPrompt" placeholder="Go ahead :) Say 'hi'"><?php /* TODO: Make this placeholder randomized at some point! */ ?>
        </form>
        <div class="sender_button_container">
            <button class="send_message" id="submit"><i class="material-icons">send</i></button>
        </div>
    </div>
</div>
<?php include_once(__DIR__.'/tabs.php'); ?>
</main>
<?php include_once(__DIR__.'/modal.php'); ?>
<?php require_once(__DIR__.'/footer.php'); ?>