$(document).ready(function() {
    const message = document.querySelector("#newPrompt");
    let messageCount = 0;
    let allow_send = true;

    const form = document.getElementById("sender_input");

    /*
      TODO: Test if this is worth doing.
      (attempts to prevent page refresh on screen pulldown;
      may break scrolling).

    window.onscroll = function() {
        if(document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
            window.scrollTo(0, 0);
        }
    }
    */

    $('.register').click(function(event) {
        $('#modal-container').addClass('active');
        $('#modal-register').addClass('active');
    });

    $('.login').click(function(event) {
        $('#modal-container').addClass('active');
        $('#modal-login').addClass('active');
    });

    $('#close-modal').click(function(event) {
        $('.form-error').html("").css('display', 'none');
        $('#modal-container').removeClass('active');
        $('#modal-register').removeClass('active');
        $('#modal-login').removeClass('active');
    });

    $('#modal-container').click(function(event) {
        if (event.target.id === 'modal-container') {
            $('.form-error').html("").css('display', 'none');
            $('#modal-container').removeClass('active');
            $('#modal-register').removeClass('active');
            $('#modal-login').removeClass('active');
        }
    });

    $('#register-user').submit(function(event) {
        event.preventDefault();

        $('.form-error').html("").css('display', 'none');

        var username = $("#register-user input[name='username']").val();
        var email = $("#register-user input[name='email']").val();
        var password = $("#register-user input[name='password']").val();
        var confirmPassword = $("#register-user input[name='confirm_password']").val();
    
        if(!username || !email || !password || !confirmPassword) {
            $('.form-error').html("Oops! Looks like something's missing?<br>Double-check that all fields are filled in.").css('display', 'block');
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailRegex.test(email)) {
            $('.form-error').html("Invalid email format.").css('display', 'block');
            return;
        }

        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        if(!passwordRegex.test(password)) {
            $('.form-error').html("Password must contain at least one uppercase letter, one lowercase letter, one number, and be at least 8 characters long.").css('display', 'block');
            return;
        }

        if(password !== confirmPassword) {
            $('.form-error').html("Looks like your passwords don't match. Make sure they're both typed exactly the same.").css('display', 'block');
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'account.php',
            data: $(this).serialize(),
            success: function(response) {
                $('.form-confirmation').html(response).css('display', 'block');
            },
            error: function(xhr, status, error) {
                $('.form-error').html("Error: " + error).css('display', 'block');
                console.error("Error: " + error);
            },
            timeout: 5000 // 5 seconds
        });
    });

    form.onsubmit = function() {
        // Remove the placeholder text from the input fields.
        for (const input of form.querySelectorAll("input")) {
            input.placeholder = "";
        }

        // Prevent the form from being submitted.
        this.preventDefault();
        $('#newPrompt').val('');
    };

    $('.tab').on('click', function(event) {
        event.preventDefault();
        // Get the id of the clicked tab.
        var tabId = this.href.split('#')[1];
        // Hide the current content div.
        $('.tabbed-content').hide();
        // Show the content div associated with the clicked tab.
        $('#' + tabId).show();
    });


    function addToArray(role, content) {
        let temp = [role, content];
        return temp;
    }

    function htmlMessage(role, content) {
        let s = "";
        if (content != '[start]') {
            who = role == 'user' ? 'You' : 'Samantha'; // TODO: Change to PHP use of name; </p>grab from either global or POST.
            s = "<div class="+role+">"+who+":</div><div class=\"message\">"+content+"</div>\n"; // TODO: Filter content for html chars.
        }
        return s;
    }

    function htmlConvo(convo) {
        let s = "";
        if (Array.isArray(convo) && convo.length > 0) {
        for (var i = 0; i < convo.length; i++) {
            s += htmlMessage(convo[i][0], convo[i][1]);
        }
        }
        return s;
    }

    $('#newPrompt').keydown(function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            if ($('#newPrompt').val() != '') {
                $('#submit').click();
            }
        }
    });

// TODO : Disable button until response is received.
    $('#submit').click(function(event) {
        event.preventDefault();
        if (allow_send) {
            allow_send = false;
            let newPromptText = $("#newPrompt").val();
            $('#submit').prop('disabled', true);
            /* let newPromptText = $("#newPrompt").serialize(); */
            let convoSoFar = $('#messages').html();
                /* let convoSoFar = $('#messages').text(); */
    
            // Remove the placeholder text from the input fields.
            for(const input of form.querySelectorAll("input")) {
                input.placeholder = "";
            }

            fullConvo.push(addToArray('user', newPromptText));
                htmlMessage('user', newPromptText);
        
            out = htmlConvo(fullConvo);   
                                                                                    // NOTE: CURRENTLY MISSING: html template
            $('#messages').html(out);                        // TODO: newPromptText should be appended to the previous HTML <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
            $('#messages').scrollTop($("#messages")[0].scrollHeight);
                $('#newPrompt').val('');

            $.ajax({
                type: 'POST',
                url: 'chat.php',
                    data: {newPromptText: newPromptText, fullConvo: fullConvo},
        
                success: function (response) {
                    $('#submit').prop('disabled', false);
                    /* let converted = arrayToHtml(newPromptText); */
                    fullConvo.push(addToArray('assistant',response));
                    messageCount++;
            // TODInsert htmlMessage() update.
                    converted = htmlConvo(fullConvo);
                    /* fullConvo.push(converted); */

                    $('#messages').html(converted);
                    allow_send = true;
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                },
                timeout: 10000 // 10 seconds
            });
        }
    });
});
