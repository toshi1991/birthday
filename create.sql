drop table if exists `movies` ;

create table `movies` (
  `id` INT unsigned auto_increment not null comment '動画ID'
  , `message_id` INT not null comment 'メッセージID'
  , `path` VARCHAR(255) not null comment 'パス'
  , `created` DATETIME not null comment '作成日時'
  , `modified` DATETIME not null comment '更新日時'
  , `del_flg` INT default 0 not null comment '削除フラグ'
  , constraint `movies_PKC` primary key (`id`)
) comment '動画' ;

-- 画像
drop table if exists `images` ;

create table `images` (
  `id` INT unsigned auto_increment not null comment '画像ID'
  , `message_id` INT not null comment 'メッセージID'
  , `data` MEDIUMBLOB not null comment '画像データ'
  , `thumb` BLOB not null comment 'サムネイル'
  , `type` VARCHAR(64) not null comment 'MIME-TYPE'
  , `created` DATETIME not null comment '作成日時'
  , `modified` DATETIME not null comment '更新日時'
  , `del_flg` INT default 0 not null comment '削除フラグ'
  , constraint `images_PKC` primary key (`id`)
) comment '画像' ;

-- メッセージ
drop table if exists `messages` ;

create table `messages` (
  `id` INT unsigned auto_increment not null comment 'メッセージID'
  , `user_id` INT not null comment 'ユーザーID'
  , `name` VARCHAR(255) not null comment '投稿者'
  , `comment` TEXT comment 'メッセージ'
  , `created` DATETIME not null comment '作成日'
  , `modified` DATETIME not null comment '更新日'
  , `del_flg` INT default 0 not null comment '削除フラグ'
  , constraint `messages_PKC` primary key (`id`)
) comment 'メッセージ' ;

-- ユーザー
drop table if exists `users` ;

create table `users` (
  `id` INT unsigned auto_increment not null comment 'ユーザーID'
  , `user_name` VARCHAR(255) not null comment 'ユーザー名'
  , `password` VARCHAR(32) not null comment 'パスワード'
  , `admin_flg` TINYINT default 0 not null comment '管理者フラグ'
  , `created` DATETIME not null comment '作成日'
  , `modified` DATETIME not null comment '更新日時'
  , `del_flg` INT default 0 not null comment '削除フラグ'
  , constraint `users_PKC` primary key (`id`)
) comment 'ユーザー' ;
