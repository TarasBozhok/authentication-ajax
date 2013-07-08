jQuery(function($) {
    var validationRules = {
        login: [
            {
                regex: /^.+$/,
                alert: 'Login field is required'
            }, {
                regex: /^[a-z]/,
                alert: 'Login must begin with letter'
            }, {
                regex: /^[\w_]+$/,
                alert: 'Invalid characters entered'
            }, {
                regex: /^.{6,}$/,
                alert: 'Login must be at least 6 characters'
            }
        ],
        password: [
            {
                regex: /^.+$/,
                alert: 'Password field is required'
            }, {
                regex: /^.{8,}$/,
                alert: 'Password must be at least 8 characters'
            }, {
                regex: /^[\w]+$/,
                alert: 'Invalid characters entered'
            }
        ]
    };



    var $content = $('#content'),
        $form = $('#login-form'),
        $mask = $('#mask'),
        $modal;


    /**
     *
     */
    $.each(validationRules, function(name, rules) {
        var $input = $('[name="' +name + '"]', $form);

        if (!$input.size()) return;

        $input.on('change keyup blur click focus', function(e) {
            validate(name, rules, true);
        });
    });

    /**
     *
     * @param name
     * @param rules
     * @param check
     */
    function validate(name, rules, check) {
        var $input = $('[name="' +name + '"]', $form),
            $block = $input.closest('.control-group'),
            $hint  = $('.help-inline', $block),
            hasValidationErrors = false;

        $.each(rules, function(i, rule) {
            if (!hasValidationErrors) {
                if (rule.regex.test($input.val())) {
                    $hint.text('');
                    $block.addClass('success').removeClass('error warning');
                } else {
                    hasValidationErrors = true;
                    $hint.text(rule.alert);
                    $block.addClass(check ? 'warning' : 'error');
                    $block.removeClass(check ? 'error' : 'warning');
                    $block.removeClass('success');
                }
            }
        });

        return !hasValidationErrors;
    }

    /**
     * Modals
     */
    $mask.on('click', function() {
        $modal.fadeOut(200);
    });

    $('a[href^="#"]', $content).on('click', function(e) {
        var $target = $(this.hash);

        if ($target.length) {
            e.preventDefault();
            $target.css({
               top: (window.innerHeight - $target.height())/2,
               left: (window.innerWidth - $target.width())/2
            });
            $modal = $mask.add($target);
            $modal.fadeIn(300);
        }
    });

    /**
     *
     */
    $form.on('submit', function(e) {
        var isValid = true,
            ajaxUrl = $form.action; //our controller action which handle AJAX request

        e.preventDefault();

        $.each(validationRules, function(name, rules) {
            if (!validate(name, rules, false)) {
                isValid = false;
            }
        });

        if (!isValid) return;

        $.post(ajaxUrl, $form.serialize(), function(html) {
            if (html.length) {
                $modal.fadeOut(200);
                $content.html(html);
            }
        });
    });
});