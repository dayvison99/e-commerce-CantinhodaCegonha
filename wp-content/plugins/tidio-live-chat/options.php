<script>
    var nonce = '<?php echo wp_create_nonce(TidioLiveChat::TIDIO_XHR_NONCE_NAME); ?>';
    var tidioApiUrl = '<?php echo TidioLiveChatConfig::getApiUrl(); ?>';
    var tidioPanelUrl = '<?php echo TidioLiveChatConfig::getPanelUrl(); ?>';
</script>
<div id="tidio-wrapper">
    <div class="tidio-box-wrapper">
        <div class="tidio-box tidio-box-actions">
        <div class="logos">
            <div class="logo tidio-logo"></div>
            <div class="logo wp-logo"></div>
        </div>
            <form novalidate id="tidio-start">
                <h1><?php i18n::_e('Start using Tidio');?></h1>
                <label>
                    <?php i18n::_e('Email Address');?>
                    <input type="email" id="email" placeholder="e.g. tidius@tidio.com" required/>
                </label>

                <div class="error"></div>
                <button><?php i18n::_e('Let’s go');?></button>
            </form>
            <form novalidate id="tidio-login">
                <h1><?php i18n::_e('Log into your account');?></h1>
                <label>
                    <?php i18n::_e('Email Address');?>
                    <input type="email" id="email" placeholder="e.g. tidius@tidio.com" required/>
                </label>

                <label>
                    <?php i18n::_e('Password');?>
                    <input type="password" id="password" placeholder="<?php i18n::_e('Type your password');?>&hellip;" required/>
                </label>

                <div class="error"></div>
                <button><?php i18n::_e('Go to Tidio panel');?></button>
                <a class="button btn-link" href="https://www.tidio.com/panel/forgot-password" target="_blank"><?php i18n::_e('Forgot password?');?></a>
            </form>
            <form novalidate id="tidio-project">
                <h1><?php i18n::_e('Choose your project');?></h1>
                <label>
                    <?php i18n::_e('Choose your project');?>
                    <div class="custom-select">
                        <select name="select-tidio-project" id="select-tidio-project">
                            <option selected="selected" disabled><?php i18n::_e('Pick one from the list');?>&hellip;</option>
                        </select>
                    </div>
                </label>

                <div class="error"></div>
                <button><?php i18n::_e('Go to Tidio panel');?></button>
                <button type="button" id="start-over" class="btn-link"><?php i18n::_e('Start all over again');?></button>
            </form>
            <form id="after-install-text">
                <h1><?php i18n::_e('Your site is already integrated with Tidio Chat');?></h1>
                <p><?php i18n::_e('All you need to do now is select the “Tidio Chat” tab on the left - that will take you to your Tidio panel. You can also open the panel by using the link below.');?></p>
                <a href="#" id="open-panel-link" class="button" target="_blank"><?php i18n::_e('Go to Panel');?></a>
            </form>
        </div>
        <div class="tidio-box tidio-box-george">
            <h2><?php i18n::_e('Join 300 000+ websites using Tidio - Live Chat boosted with Bots');?></h2>
            <p><?php i18n::_e('Increase sales by skyrocketing communication with customers.');?></p>
            <div class="tidio-box-george-image"></div>
        </div>
    </div>
</div>
