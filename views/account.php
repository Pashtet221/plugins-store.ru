<article id="n-273-86" class="scene n-273-86" ><div id="n-273-87" class="layer n-273-87 section backdrop-layer ornament" ></div>
<header id="n-273-88" class="layer n-273-88 section site-header" ><a id="n-273-89" class="layer n-273-89 text" href="<?php echo esc_url(psv3_url('home')); ?>">plugins.store</a>
<button id="n-273-90" class="layer n-273-90 text" data-open="mega" type="button">Плагины</button>
<a id="n-273-91" class="layer n-273-91 text" href="<?php echo esc_url(psv3_url('services')); ?>">Услуги</a>
<a id="n-273-92" class="layer n-273-92 text" href="<?php echo esc_url(psv3_url('home')); ?>#n-240-134">Мини-кейсы</a>
<a id="n-273-93" class="layer n-273-93 text" href="<?php echo esc_url(psv3_url('purchase-terms')); ?>">Документация</a>
<button id="n-273-94" class="layer n-273-94" data-open="profile-menu" type="button"><span id="n-273-95" class="layer n-273-95 text" >Мой профиль</span>
</button>
<div id="n-273-96" class="layer n-273-96" ><div id="n-273-97" class="layer n-273-97 image-layer" ><img src="<?php echo esc_url(get_theme_file_uri('/assets/media/273_97.png')); ?>" alt="" style="object-fit:fill"></div>
</div>
<a id="n-275-268" class="layer n-275-268 text" href="<?php echo esc_url(psv3_url('blog')); ?>">Блог</a>
<a id="n-277-176" class="layer n-277-176 text" href="<?php echo esc_url(psv3_url('contacts')); ?>">Контакты</a>
<?php get_template_part('views/mobile-nav-toggle'); ?>
</header>
<a id="n-273-98" class="layer n-273-98 text section" href="<?php echo esc_url(psv3_url('home')); ?>">Главная</a>
<span id="n-273-99" class="layer n-273-99 text section" >/  Личный кабинет</span>
<div id="n-273-100" class="layer n-273-100 section" ><a id="n-273-101" class="layer n-273-101 text" href="<?php echo esc_url(psv3_url('account')); ?>">Личный кабинет</a>
<span id="n-273-102" class="layer n-273-102 text" >Ключи, архивы плагинов и переписка с поддержкой.</span>
<a id="n-273-103" class="layer n-273-103" href="#n-273-115"><span id="n-273-104" class="layer n-273-104 text" >Мои лицензии</span>
<span id="n-273-105" class="layer n-273-105 text" ><?php echo esc_html(psv3_account_data('license_count')); ?></span>
<span id="n-273-106" class="layer n-273-106 text" >↓</span>
</a>
<a id="n-273-107" class="layer n-273-107" href="#n-273-128"><span id="n-273-108" class="layer n-273-108 text" >Загрузки</span>
<span id="n-273-109" class="layer n-273-109 text" ><?php echo esc_html(psv3_account_data('download_count')); ?></span>
<span id="n-273-110" class="layer n-273-110 text" >↓</span>
</a>
<a id="n-273-111" class="layer n-273-111" href="#n-273-138"><span id="n-273-112" class="layer n-273-112 text" >Обращения</span>
<span id="n-273-113" class="layer n-273-113 text" ><?php echo esc_html(psv3_account_data('ticket_count')); ?></span>
<span id="n-273-114" class="layer n-273-114 text" >↓</span>
</a>
</div>
<div id="n-273-115" class="layer n-273-115 section" ><span id="n-273-116" class="layer n-273-116 text" >Мои лицензии</span>
<span id="n-273-117" class="layer n-273-117 text" >Лицензии и ключи активации для ваших сайтов.</span>
<div id="n-273-118" class="layer n-273-118" ><span id="n-273-119" class="layer n-273-119 text" ><?php echo esc_html(psv3_account_data('license_title')); ?></span>
<span id="n-273-120" class="layer n-273-120 text" ><?php echo esc_html(psv3_account_data('domain')); ?></span>
<div id="n-273-121" class="layer n-273-121" ><span id="n-273-122" class="layer n-273-122 text" ><?php echo esc_html(psv3_account_data('license_status')); ?></span>
</div>
<div id="n-273-123" class="layer n-273-123" ><span id="n-273-124" class="layer n-273-124 text" >Ключ активации</span>
<span id="n-273-125" class="layer n-273-125 text" ><?php echo esc_html(psv3_account_data('masked')); ?></span>
<button id="n-273-126" class="layer n-273-126" data-copy-key type="button" data-key="<?php echo esc_attr(psv3_account_data("key")); ?>" <?php if (!psv3_account_data("key")) echo "disabled"; ?>><span id="n-273-127" class="layer n-273-127 text" >Копировать ключ</span>
</button>
</div>
</div>
</div>
<div id="n-273-128" class="layer n-273-128 section" ><span id="n-273-129" class="layer n-273-129 text" >Загрузки</span>
<span id="n-273-130" class="layer n-273-130 text" >Актуальные архивы для ваших лицензий.</span>
<div id="n-273-131" class="layer n-273-131" ><div id="n-273-132" class="layer n-273-132" ><span id="n-273-133" class="layer n-273-133 text" >ZIP</span>
</div>
<span id="n-273-134" class="layer n-273-134 text" ><?php echo esc_html(psv3_account_data('archive_title')); ?></span>
<span id="n-273-135" class="layer n-273-135 text" ><?php echo esc_html(psv3_account_data('archive_version')); ?></span>
<a id="n-273-136" class="layer n-273-136" href="<?php echo esc_url(psv3_account_data('download')); ?>" <?php echo psv3_account_data("download") ? "" : "hidden"; ?>><span id="n-273-137" class="layer n-273-137 text" >Скачать ZIP ↓</span>
</a>
</div>
</div>
<div id="n-273-138" class="layer n-273-138 section" ><span id="n-273-139" class="layer n-273-139 text" >Обращения</span>
<span id="n-273-140" class="layer n-273-140 text" >История переписки с поддержкой.</span>
<button id="n-273-141" class="layer n-273-141" data-open="ticket" type="button"><span id="n-273-142" class="layer n-273-142 text" >Новое обращение +</span>
</button>
<div id="n-273-143" class="layer n-273-143" ><span id="n-273-144" class="layer n-273-144 text" ><?php echo esc_html(psv3_account_data('ticket_title')); ?></span>
<span id="n-273-145" class="layer n-273-145 text" ><?php echo esc_html(psv3_account_data('ticket_number')); ?></span>
<div id="n-273-146" class="layer n-273-146" ><span id="n-273-147" class="layer n-273-147 text" ><?php echo esc_html(psv3_account_data('ticket_status')); ?></span>
</div>
</div>
<div id="n-273-148" class="layer n-273-148" ><span id="n-273-149" class="layer n-273-149 text" >Ваше сообщение</span>
<span id="n-273-150" class="layer n-273-150 text" ><?php echo esc_html(psv3_account_data('ticket_message')); ?></span>
<span id="n-273-151" class="layer n-273-151 text" >Последний ответ поддержки</span>
<span id="n-273-152" class="layer n-273-152 text" ><?php echo esc_html(psv3_account_data('ticket_reply')); ?></span>
</div>
</div>
<footer id="n-273-153" class="layer n-273-153 section site-footer" ><div id="n-273-154" class="layer n-273-154" ><div id="n-273-155" class="layer n-273-155" ><a id="n-273-156" class="layer n-273-156 text" href="<?php echo esc_url(psv3_url('home')); ?>">plugins.store</a>
<span id="n-273-157" class="layer n-273-157 text" >Плагины и разработка
для интернет-магазинов</span>
</div>
<div id="n-273-158" class="layer n-273-158" ><a id="n-273-159" class="layer n-273-159 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">Плагины</a>
<a id="n-273-160" class="layer n-273-160 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">WooCommerce</a>
<a id="n-273-161" class="layer n-273-161 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">WordPress</a>
<a id="n-273-162" class="layer n-273-162 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">1С-Битрикс</a>
</div>
<div id="n-273-163" class="layer n-273-163" ><a id="n-273-164" class="layer n-273-164 text" href="<?php echo esc_url(psv3_url('services')); ?>">Услуги</a>
<span id="n-273-165" class="layer n-273-165 text" >Разработка плагинов</span>
<span id="n-273-166" class="layer n-273-166 text" >Доработка магазинов</span>
<span id="n-273-167" class="layer n-273-167 text" >Техническая поддержка</span>
</div>
<div id="n-273-168" class="layer n-273-168" ><span id="n-273-169" class="layer n-273-169 text" >Помощь</span>
<a id="n-273-170" class="layer n-273-170 text" href="<?php echo esc_url(psv3_url('purchase-terms')); ?>">Документация</a>
<a id="n-273-171" class="layer n-273-171 text" href="<?php echo esc_url(psv3_url('account')); ?>">Личный кабинет</a>
<a id="n-273-172" class="layer n-273-172 text" href="<?php echo esc_url(psv3_telegram()); ?>">Telegram</a>
</div>
</div>
<div id="n-273-173" class="layer n-273-173 ornament" ></div>
<div id="n-273-174" class="layer n-273-174" ><span id="n-273-175" class="layer n-273-175 text" >© Plugins-store</span>
<div id="n-273-176" class="layer n-273-176" ><a id="n-273-177" class="layer n-273-177 text" href="<?php echo esc_url(psv3_url('privacy')); ?>">Политика конфиденциальности</a>
<a id="n-273-178" class="layer n-273-178 text" href="<?php echo esc_url(psv3_url('offer')); ?>">Публичная оферта</a>
<a id="n-273-179" class="layer n-273-179 text" href="<?php echo esc_url(psv3_url('purchase-terms')); ?>">Гарантии и возврат</a>
</div>
</div>
</footer>
</article>
