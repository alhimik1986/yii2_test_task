-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.29 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных yii2basic
CREATE DATABASE IF NOT EXISTS `yii2basic` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yii2basic`;


-- Дамп структуры для таблица yii2basic.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы yii2basic.auth_assignment: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('admin', '1', 1504841681),
	('manager', '2', 1504841681),
	('user', '3', 1504841681);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.auth_item
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы yii2basic.auth_item: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('admin', 1, 'Админ', NULL, NULL, 1504841681, 1504841681),
	('createNews', 2, 'Создавать новости', NULL, NULL, 1504841681, 1504841681),
	('deleteNews', 2, 'Удалять новости', NULL, NULL, 1504841681, 1504841681),
	('deleteOwnNews', 2, 'Удалять свои новости', 'isAuthor', NULL, 1504841681, 1504841681),
	('editNews', 2, 'Редактировать новости', NULL, NULL, 1504841681, 1504841681),
	('editOwnNews', 2, 'Редактировать свои новости', 'isAuthor', NULL, 1504841681, 1504841681),
	('manager', 1, 'Менеджер', NULL, NULL, 1504841681, 1504841681),
	('user', 1, 'Пользователь', NULL, NULL, 1504841681, 1504841681),
	('viewNews', 2, 'Просматривать новости', NULL, NULL, 1504841681, 1504841681);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.auth_item_child
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы yii2basic.auth_item_child: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('admin', 'createNews'),
	('manager', 'createNews'),
	('admin', 'deleteNews'),
	('manager', 'deleteOwnNews'),
	('admin', 'editNews'),
	('manager', 'editOwnNews'),
	('admin', 'viewNews'),
	('manager', 'viewNews');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.auth_rule
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Дамп данных таблицы yii2basic.auth_rule: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
	('isAuthor', _binary 0x4F3A33323A226170705C6D6F64756C65735C6E6577735C726261635C417574686F7252756C65223A333A7B733A343A226E616D65223B733A383A226973417574686F72223B733A393A22637265617465644174223B693A313530343834313638313B733A393A22757064617465644174223B693A313530343834313638313B7D, 1504841681, 1504841681);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.migration: ~10 rows (приблизительно)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1504504842),
	('m140506_102106_rbac_init', 1504504843),
	('m170901_151156_create_users_table', 1504841680),
	('m170901_151616_create_table_news', 1504841680),
	('m170901_152009_create_table_notification_template', 1504841681),
	('m170902_191214_add_default_rbac', 1504841681),
	('m170904_193109_create_table_news_notifier', 1504841681),
	('m170906_083139_create_table_notification', 1504841681),
	('m170907_050627_create_table_notification_special', 1504841681),
	('m170907_051936_create_table_notification_special_user', 1504841682);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `preview` text,
  `full_text` text,
  `status` int(11) NOT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.news: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`id`, `title`, `preview`, `full_text`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
	(1, 'Сирия и Израиль заинтересовались российскими "Терминаторами"', '<p><strong>МОСКВА, 7 сен&nbsp;&mdash; РИА Новости.&nbsp;</strong>Сирия и&nbsp;Израиль одновременно проявили интерес к&nbsp;закупке российских боевых машин поддержки танков (БМПТ) типа &quot;Терминатор&quot;, заявил журналистам в&nbsp;четверг начальник Главного автобронетанкового управления Минобороны РФ Александр Шевченко.</p>\r\n', '<p><strong>МОСКВА, 7 сен&nbsp;&mdash; РИА Новости.&nbsp;</strong>Сирия и&nbsp;Израиль одновременно проявили интерес к&nbsp;закупке российских боевых машин поддержки танков (БМПТ) типа &quot;Терминатор&quot;, заявил журналистам в&nbsp;четверг начальник Главного автобронетанкового управления Минобороны РФ Александр Шевченко.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/defense_safety/20170824/1501006421.html?inj=1" target="_blank"><img alt="Танк Т-14 Армата на международном военно-техническом форуме Армия-2017" src="https://cdn2.img.ria.ru/images/150100/67/1501006756.jpg" /></a></p>\r\n\r\n<p><a href="http://www.rian.ru/docs/about/copyright.html">&copy; РИА Новости / Виталий Белоусов</a></p>\r\n\r\n<p><a href="http://visualrian.ru/images/item/3175427" target="_blank">Перейти в фотобанк</a></p>\r\n\r\n<p><a href="https://ria.ru/defense_safety/20170824/1501006421.html?inj=1" target="_blank">Минобороны получит 100 танков &quot;Армата&quot; до 2020 года</a></p>\r\n\r\n<p>Ранее в&nbsp;ходе военно-технического форума &quot;Армия-2017&quot; Минобороны России подписало контракт с &quot;Уралвагонзаводом&quot; на&nbsp;поставку партии этих машин, до&nbsp;этого БМПТ типа &quot;Терминатор&quot; производились исключительно на&nbsp;экспорт.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&quot;В этом году на&nbsp;вооружение ВС РФ будет принята машина принципиально нового класса &ndash; боевая машина поддержки танков, интерес к&nbsp;которой проявили уже многие страны, в&nbsp;первую очередь Израиль и&nbsp;Сирия&quot;,&nbsp;&mdash; сказал Шевченко.</p>\r\n\r\n<p>БМПТ &quot;Терминатор&quot;, во&nbsp;многом не&nbsp;имеющие аналогов в&nbsp;мире, предназначены для&nbsp;защиты танков от&nbsp;пехоты противника. Эти машины вооружены двумя 30-миллиметровыми автоматическими пушками 2А42 с&nbsp;дальностью стрельбы до&nbsp;четырех километров и&nbsp;боекомплектом в&nbsp;850 снарядов. Помимо этого, вооружение включает также четыре сверхзвуковые управляемые ракеты комплекса &quot;Атака-Т&quot;, два 30-миллиметровых автоматических гранатомета АГ-17Д и&nbsp;спаренный с&nbsp;пушками 7,62-миллиметровый пулемет.</p>\r\n\r\n<p>&quot;Терминаторы&quot; оснащены всеракурсной баллистической защитой от&nbsp;средств поражения, высокоэффективными средствами обнаружения целей, автоматизированной системой управления огнем.</p>\r\n\r\n<p><br />\r\n<br />\r\nРИА Новости&nbsp;<a href="https://ria.ru/defense_safety/20170907/1502036030.html">https://ria.ru/defense_safety/20170907/1502036030.html</a></p>\r\n', 10, 1, 1504841946, 1504841946),
	(2, 'В Лондоне прогремел взрыв', '<p>В центре Лондона прогремел взрыв. Об этом сообщают Behind The News в своём аккаунте в Twitter со ссылкой на источники. &nbsp;Далее: https://news.rambler.ru/incidents/37846967/?utm_content=news&amp;utm_medium=read_more&amp;utm_source=copylink</p>\r\n', '<p>В центре Лондона прогремел взрыв. Об этом сообщают Behind The News в своём аккаунте в Twitter со ссылкой на источники.&nbsp;<br />\r\nВзрыв произошёл на улице Оксфорд-стрит. Очевидцы сообщают о начавшейся паники в районе происшествия и задымлении. По одной из версий, причиной взрыва стала поломка на электроподстанции. В настоящее время на месте происшествия работают сотрудники экстренных служб города. На момент написания новости информация о жертвах не поступала.<br />\r\n&nbsp;Далее: https://news.rambler.ru/incidents/37846967/?utm_content=news&amp;utm_medium=read_more&amp;utm_source=copylink</p>\r\n', 10, 1, 1504841994, 1504841994),
	(3, 'На загруженном перекрёстке возле Речного вокзала на день отключают светофоры', '<p>Сегодня, 8 сентября, в Новосибирске на день отключат светофоры на одном из перекрёстков улицы Восход.</p>\r\n', '<p><a href="https://static.ngs.ru/news/99/preview/61885775c07123a7b3b276ea735e743b07271cfa_900.JPG"><img alt="На загруженном перекрёстке возле Речного вокзала на день отключают светофоры" src="https://static.ngs.ru/news/99/preview/61885775c07123a7b3b276ea735e743b07271cfa_700.JPG" /></a></p>\r\n\r\n<p>Сегодня, 8 сентября, в Новосибирске на день отключат светофоры на одном из перекрёстков улицы Восход.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&laquo;В&nbsp;течение дня на пересечениях улиц Восход и Зыряновская ведутся работы по переносу кабеля. Светофор будет отключен&raquo;, &mdash;&nbsp;рассказали в&nbsp;специализированном монтажно-эксплуатационном учреждении (СМЭУ). Специалисты отметили, что сейчас бригада рабочих уже отправилась на перекрёсток.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Кроме того, с&nbsp;11:00 до 14:00&nbsp; на площади Кирова со стороны улицы Громова на пешеходном переходе не будет работать светофор&nbsp; &mdash;&nbsp;его будут ремонтировать.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Также в СМЭУ рассказали, что на улице Перевозчикова рядом с площадью Калинина на пешеходном переходе, который раньше был нерегулируемым, начал работать новый светодиодный светофор с обратным отсчетом.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Вчера&nbsp;на три часа отключали светофоры&nbsp;<a href="http://news.ngs.ru/more/51183751/" target="_blank">на перекрёстке Красного проспекта и улицы Георгия Колонды в Заельцовском районе</a>.&nbsp;</p>\r\n', 10, 1, 1504842024, 1504842024),
	(4, 'СМИ рассказали о записях Манафорта по расследованию в отношении сына Трампа', '<p><strong>ВАШИНГТОН, 8 сен&nbsp;&mdash; РИА Новости, Алексей Богдановский.</strong>&nbsp;Американские следователи не&nbsp;нашли компрометирующей информации в&nbsp;конспекте встречи Дональда Трампа-младшего и&nbsp;других с&nbsp;несколькими гражданами России, включая юриста Наталью Весельницкую, сообщило издание&nbsp;<a href="http://www.politico.com/story/2017/09/07/russian-meeting-notes-not-damaging-to-trump-family-242464" target="_blank">Politico</a>&nbsp;со&nbsp;ссылкой на&nbsp;несколько источников, знакомых с&nbsp;конспектом.</p>\r\n', '<p><strong>ВАШИНГТОН, 8 сен&nbsp;&mdash; РИА Новости, Алексей Богдановский.</strong>&nbsp;Американские следователи не&nbsp;нашли компрометирующей информации в&nbsp;конспекте встречи Дональда Трампа-младшего и&nbsp;других с&nbsp;несколькими гражданами России, включая юриста Наталью Весельницкую, сообщило издание&nbsp;<a href="http://www.politico.com/story/2017/09/07/russian-meeting-notes-not-damaging-to-trump-family-242464" target="_blank">Politico</a>&nbsp;со&nbsp;ссылкой на&nbsp;несколько источников, знакомых с&nbsp;конспектом.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/world/20170907/1502032607.html?inj=1" target="_blank"><img alt="Дональд Трамп-младший. Архивное фото" src="https://cdn3.img.ria.ru/images/147742/00/1477420093.jpg" /></a></p>\r\n\r\n<p>&copy; AP Photo / J. Scott Applewhite</p>\r\n\r\n<p><a href="https://ria.ru/world/20170907/1502032607.html?inj=1" target="_blank">Трамп-младший рассказал, зачем встречался с российским адвокатом</a></p>\r\n\r\n<p>По данным Politico, следователи изучили конспект встречи, составленный тогдашним руководителем предвыборного штаба Трампа-старшего Полом Манафортом. Вопреки многочисленным утечкам в&nbsp;СМИ, в&nbsp;конспекте нет ни&nbsp;упоминаний об&nbsp;обсуждении компромата на&nbsp;соперника Трампа Хиллари Клинтон ни&nbsp;взаимных обязательств услуг и&nbsp;денежной помощи, пишет Politico. При этом, по&nbsp;его данным, нет точных доказательств, что Манафорт составил полный конспект.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Записи Манафорта уже видели в&nbsp;конгрессе, где ведется независимое расследование &quot;сговора Трампа с&nbsp;Россией&quot;.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/world/20170906/1501936959.html?inj=1" target="_blank"><img alt="Адвокат Наталья Весельницкая. Архивное фото" src="https://cdn1.img.ria.ru/images/149977/59/1499775987.jpg" /></a></p>\r\n\r\n<p><a href="http://www.rian.ru/docs/about/copyright.html">&copy; РИА Новости / Евгений Биятов</a></p>\r\n\r\n<p><a href="https://ria.ru/world/20170906/1501936959.html?inj=1" target="_blank">Власти США не связывались с Весельницкой по поводу встречи с сыном Трампа</a></p>\r\n\r\n<p>Спецпрокурор США Роберт Мюллер расследует встречу Трампа-младшего с&nbsp;Весельницкой и&nbsp;некоторыми другими людьми, его интересует, не&nbsp;предлагал ли Трамп-младший или&nbsp;кто-то другой из&nbsp;предвыборного штаба Трампа-старшего российским представителям опубликовать компрометирующую информацию о&nbsp;Клинтон. Мюллер расследует предполагаемые связи Трампа с&nbsp;Россией, которые отрицают как&nbsp;в Кремле, так и&nbsp;в Белом доме. О каких-либо выводах расследования он не&nbsp;сообщал.<br />\r\n<br />\r\nРИА Новости&nbsp;<a href="https://ria.ru/world/20170908/1502043484.html">https://ria.ru/world/20170908/1502043484.html</a></p>\r\n', 10, 1, 1504842066, 1504842066),
	(5, 'Сирийские семьи возвращаются в район Африн на севере Алеппо', '<p><strong>АЛЕППО (Сирия), 8 авг&nbsp;&mdash; РИА Новости.</strong>&nbsp;Более 50 сирийских семей вернулись в&nbsp;свои дома в&nbsp;район Африн на&nbsp;севере провинции Алеппо, которые они оставили несколько лет назад из-за войны, сообщил РИА Новости представитель российского центра по&nbsp;примирению враждующих сторон (ЦПВС) в&nbsp;Сирии Виктор Фролов.<br />\r\n<br />\r\nРИА Новости&nbsp;<a href="https://ria.ru/syria/20170908/1502043378.html">https://ria.ru/syria/20170908/1502043378.html</a></p>\r\n', '<p><strong>АЛЕППО (Сирия), 8 авг&nbsp;&mdash; РИА Новости.</strong>&nbsp;Более 50 сирийских семей вернулись в&nbsp;свои дома в&nbsp;район Африн на&nbsp;севере провинции Алеппо, которые они оставили несколько лет назад из-за войны, сообщил РИА Новости представитель российского центра по&nbsp;примирению враждующих сторон (ЦПВС) в&nbsp;Сирии Виктор Фролов.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170908/1502040678.html?inj=1" target="_blank"><img alt="Ситуация в Дейр-эз-Зоре. Архивное фото" src="https://cdn3.img.ria.ru/images/150189/75/1501897518.jpg" /></a></p>\r\n\r\n<p>&copy; Sputnik / Kamel Saqr</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170908/1502040678.html?inj=1" target="_blank">Клинцевич объяснил, зачем США эвакуировали главарей ИГ* из Сирии</a></p>\r\n\r\n<p>&quot;Благодаря усилиями ЦПВС были достигнуты определенные договоренности о&nbsp;возвращении мирных жителей в&nbsp;населенные пункты кантона (района) Африн. За последние несколько дней в&nbsp;свои дома вернулась 51 семья. Из них из&nbsp;лагеря беженцев &quot;Джибрин&quot; в&nbsp;город Ахрас вернулись пять семей&quot;,&nbsp;&mdash; сказал представитель центра по&nbsp;примирению.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Кроме того, по&nbsp;его словам, военнослужащие центра передали 200 школьных укомплектованных рюкзаков непосредственно в&nbsp;город Африн от&nbsp;юнармейцев России и&nbsp;500 килограммов медикаментов в&nbsp;местные больницы.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170907/1502038727.html?inj=1" target="_blank"><img alt="Бойцы армии САР прорвавшие трехлетнюю осаду города Дейр-эз-Зор в районе территории 137-й механизированной бригады" src="https://cdn2.img.ria.ru/images/150181/49/1501814991.jpg" /></a></p>\r\n\r\n<p>&copy; Фото : предоставлено пресс-службой президента Сирии</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170907/1502038727.html?inj=1" target="_blank">Губернатор Дейр эз-Зора рассказал о прорыве блокады ИГ* сирийской армией</a></p>\r\n\r\n<p>Несмотря на&nbsp;то что в&nbsp;районе Африн нет зоны деэскалации, здесь действует так называемая зона деконфликтации, и&nbsp;работает российский центр по&nbsp;примирению. Как ранее сообщали в&nbsp;центре, в&nbsp;конце августа в&nbsp;районе Африн для&nbsp;восстановления мирной жизни был создан комитет национального примирения, в&nbsp;который вошли представители местных органов самоуправления провинций, оппозиции и&nbsp;российского центра по&nbsp;примирению.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>За годы, пока в&nbsp;районе Африн находились террористы, местные жители лишились земли и&nbsp;домов, многие бежали, а&nbsp;тех, кто оставался, боевики пытали или&nbsp;убивали. Теперь в&nbsp;один из&nbsp;городов Африна&nbsp;&mdash; Телль-Рифъат&nbsp;&mdash; снова возвращаются люди. Только за&nbsp;последнее время сюда прибыли более 25 семей, одна из&nbsp;них&nbsp;&mdash; 34 человека&nbsp;&mdash; семья Хамеда Муратажа. Сейчас они все вместе восстанавливает дом и&nbsp;очень надеются на&nbsp;мир.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170907/1502029379.html?inj=1" target="_blank"><img alt="Сирийские военные в окрестностях Дейр-эз-Зора. Архивное фото" src="https://cdn5.img.ria.ru/images/150182/32/1501823225.jpg" /></a></p>\r\n\r\n<p>&copy; Фото : SANA</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170907/1502029379.html?inj=1" target="_blank">Эксперт: Трамп должен инициировать расследование эвакуации главарей ИГ*</a></p>\r\n\r\n<p>&quot;Я был предпринимателем до&nbsp;войны, жил здесь до&nbsp;последнего, уехали отсюда в&nbsp;начале 2016 года из-за террористов. Недавно мы вернулись сюда, в&nbsp;Телль-Рифъат, потому что здесь стало безопасно&hellip; Когда с&nbsp;этих земель выгнали террористов, люди стали возвращаться в&nbsp;свои дома, сейчас, с&nbsp;появлением российской военной полиции в&nbsp;этом районе, люди еще больше успокоились и&nbsp;возвращаются целыми семьями в&nbsp;Телль-Рифъат. Дома рядом в&nbsp;основном пустуют, но&nbsp;скоро все вернутся, многие подают заявления в&nbsp;муниципалитет на&nbsp;возвращение&quot;,&nbsp;&mdash; рассказывает местный житель Хамед Муратаж.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170907/1502022520.html?inj=1" target="_blank"><img alt="Сирийские военные продолжают операцию по деблокированию Дейр-эз-Зора. Архивное фото" src="https://cdn4.img.ria.ru/images/150194/78/1501947824.jpg" /></a></p>\r\n\r\n<p>&copy; Sputnik</p>\r\n\r\n<p><a href="https://ria.ru/syria/20170907/1502022520.html?inj=1" target="_blank">Коалиция США отрицает эвакуацию командиров ИГ*</a></p>\r\n\r\n<p>По его словам, магазин, который он держал, располагался напротив его дома, а&nbsp;сейчас полностью разрушен. В доме Хамеда террористы устроили пожар, в&nbsp;итоге несколько комнат сгорели, а&nbsp;в одной из&nbsp;них погиб его сын. Из-за многочисленных обстрелов второй этаж дома практически разрушен, а&nbsp;там, где сохранились стены и&nbsp;часть крыши, сейчас сложены вещи. Дома его соседей пострадали еще больше: стен нет совсем, уцелели только опоры.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Один из&nbsp;его сыновей Ринас рассказывает, что обстрелы велись беспорядочно, люди гибли и&nbsp;в домах, и&nbsp;на полях за&nbsp;работой. По его словам, террористы требовали у&nbsp;местных жителей деньги. Тех, у&nbsp;кого их не&nbsp;было, убивали, а&nbsp;их дома сжигали. Теперь Ринас, как&nbsp;и его отец, надеется на&nbsp;мирное будущее, которое, по&nbsp;его словам, стало реальным с&nbsp;приходим в&nbsp;Африн российской военной</p>\r\n\r\n<p><br />\r\n<br />\r\nРИА Новости&nbsp;<a href="https://ria.ru/syria/20170908/1502043378.html">https://ria.ru/syria/20170908/1502043378.html</a></p>\r\n', 10, 1, 1504842109, 1504842109),
	(6, 'В Майами терминал аэропорта закрыли из-за стрельбы', '<p><strong>МОСКВА, 8 сен&nbsp;&mdash; РИА Новости.</strong>&nbsp;Терминал международного аэропорта Майами (MIA) закрыт из-за инцидента со&nbsp;стрельбой, полиция прибыла на&nbsp;место событий.<br />\r\n<br />\r\nРИА Новости&nbsp;<a href="https://ria.ru/world/20170908/1502043284.html">https://ria.ru/world/20170908/1502043284.html</a></p>\r\n', '<p><strong>МОСКВА, 8 сен&nbsp;&mdash; РИА Новости.</strong>&nbsp;Терминал международного аэропорта Майами (MIA) закрыт из-за инцидента со&nbsp;стрельбой, полиция прибыла на&nbsp;место событий.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><a href="https://ria.ru/world/20170902/1501629521.html?inj=1" target="_blank"><img alt="Сотрудники Украинской полиции. Архивное фото" src="https://cdn3.img.ria.ru/images/147287/45/1472874588.jpg" /></a></p>\r\n\r\n<p><a href="http://www.rian.ru/docs/about/copyright.html">&copy; РИА Новости / Стрингер</a></p>\r\n\r\n<p><a href="http://visualrian.ru/images/item/2860156" target="_blank">Перейти в фотобанк</a></p>\r\n\r\n<p><a href="https://ria.ru/world/20170902/1501629521.html?inj=1" target="_blank">В Одессе неизвестные устроили стрельбу и сообщили о минировании аэропорта</a></p>\r\n\r\n<p>&quot;Инцидент, связанный с&nbsp;нарушением безопасности, с&nbsp;участием одного подозреваемого произошел в&nbsp;MIA. Ситуация под&nbsp;контролем. Терминал J временно закрыт&quot;,&nbsp;&mdash; говорится в&nbsp;заявлении, размещенном в&nbsp;официальном&nbsp;<a href="https://twitter.com/iflymia" target="_blank">Twitter</a>воздушной гавани.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>По данным полиции, инцидент связан со&nbsp;стрельбой. &quot;Угрозы или&nbsp;опасности для&nbsp;людей в&nbsp;данный момент нет&quot;,&nbsp;&mdash; отмечается в&nbsp;заявлении правоохранителей. На место прибыли сотрудники полицейского департамента округа Майами-Дейд.</p>\r\n\r\n<p><br />\r\n<br />\r\nРИА Новости&nbsp;<a href="https://ria.ru/world/20170908/1502043284.html">https://ria.ru/world/20170908/1502043284.html</a></p>\r\n', 10, 1, 1504842147, 1504842169);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.news_notifier
CREATE TABLE IF NOT EXISTS `news_notifier` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `last_news_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.news_notifier: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `news_notifier` DISABLE KEYS */;
INSERT INTO `news_notifier` (`user_id`, `last_news_id`) VALUES
	(1, 6);
/*!40000 ALTER TABLE `news_notifier` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.notification
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.notification: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` (`id`, `class_name`, `template_id`) VALUES
	(1, 'app\\modules\\notifications\\notifications\\notifications\\BrowserNotification', 2),
	(2, 'app\\modules\\notifications\\notifications\\notifications\\EmailNotification', 1);
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.notification_special
CREATE TABLE IF NOT EXISTS `notification_special` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_type_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.notification_special: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `notification_special` DISABLE KEYS */;
INSERT INTO `notification_special` (`id`, `notification_type_id`, `title`, `body`) VALUES
	(1, 1, NULL, 'Уважаемый, {username}! На нашем сайте {site_url} добавлена новая новость: <a href="{new-link}">{new-title}</a> <br> {new-description}'),
	(2, 2, NULL, 'Уважаемый, {username}! На нашем сайте {site_url} добавлена новая новость: <a href="{new-link}">{new-title}</a> <br> {new-description}');
/*!40000 ALTER TABLE `notification_special` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.notification_special_user
CREATE TABLE IF NOT EXISTS `notification_special_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.notification_special_user: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `notification_special_user` DISABLE KEYS */;
INSERT INTO `notification_special_user` (`id`, `notification_id`, `user_id`) VALUES
	(2, 2, 1);
/*!40000 ALTER TABLE `notification_special_user` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.notification_template
CREATE TABLE IF NOT EXISTS `notification_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.notification_template: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `notification_template` DISABLE KEYS */;
INSERT INTO `notification_template` (`id`, `title`, `body`) VALUES
	(1, 'E-mail шаблон', 'Уважаемый, {username}! На нашем сайте {site_url} добавлена новая новость: <a href="{new-link}">{new-title}</a> <br> {new-description}'),
	(2, 'Шаблон браузера', 'Уважаемый, {username}! На нашем сайте {site_url} добавлена новая новость: <a href="{new-link}">{new-title}</a> <br> {new-description}');
/*!40000 ALTER TABLE `notification_template` ENABLE KEYS */;


-- Дамп структуры для таблица yii2basic.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `auth_at` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2basic.user: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password_hash`, `password_reset_token`, `email`, `email_confirm_token`, `auth_key`, `status`, `created_at`, `updated_at`, `auth_at`, `full_name`) VALUES
	(1, 'admin', '$2y$13$.YosvI7JqkuX1qY/mtpWl.u.bKJeZ2a3rlAtv/lkxE5q6oofxbL8W', NULL, 'admin@admin.ru', NULL, NULL, 10, 1504841680, NULL, NULL, 'Admin'),
	(2, 'manager', '$2y$13$rkvq3KCZeUc/xTg0ZRiUm.AQUpT1iRR1kymitpuZJbOqh4xFECkzi', NULL, 'manager@manager.ru', NULL, NULL, 10, 1504841680, NULL, NULL, 'Manager'),
	(3, 'user', '$2y$13$33NbEGdAz5HmJtyBAqZWiO1Ic8VstQH7riVXqduliPg/n.TAHl5Qa', NULL, 'user@user.ru', NULL, NULL, 10, 1504841680, NULL, NULL, 'User');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
