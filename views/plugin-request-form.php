<form id="n-251-162" class="layer n-251-162 native-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"><?php psv3_form_fields('request'); ?>
<?php if (!empty($args['plugin_id'])) : ?>
<input type="hidden" name="plugin_id" value="<?php echo esc_attr($args['plugin_id']); ?>">
<?php endif; ?>
<span id="n-251-163" class="layer n-251-163 text" >Имя</span>
<div id="n-251-164" class="layer n-251-164 field" ><input type="text" name="name" aria-label="Имя" placeholder="Как к вам обращаться"></div>
<span id="n-251-166" class="layer n-251-166 text" >Email или Telegram</span>
<div id="n-251-167" class="layer n-251-167 field" ><input type="text" name="contact" aria-label="Email или Telegram" placeholder="Куда вам ответить" required></div>
<span id="n-251-169" class="layer n-251-169 text" >Сайт магазина</span>
<div id="n-251-170" class="layer n-251-170 field" ><input type="url" name="website" aria-label="Сайт магазина" placeholder="https://"></div>
<span id="n-251-172" class="layer n-251-172 text" >Комментарий</span>
<div id="n-251-173" class="layer n-251-173 field" ><textarea name="message" aria-label="Комментарий" placeholder="Например, нужна помощь с установкой"></textarea></div>
<button id="n-251-175" class="layer n-251-175" type="submit"><span id="n-251-176" class="layer n-251-176 text" >Отправить заявку →</span>
</button>
<a id="n-251-177" class="layer n-251-177 text" href="<?php echo esc_url(psv3_url('privacy')); ?>">Политика конфиденциальности ↗</a>
</form>
