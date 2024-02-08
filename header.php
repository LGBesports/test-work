<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Тестовое задание</title>
	<?php wp_head() ?>
</head>
<body>
  <div class="wrapper">
    <div class="container all">
      <header class="header">
        <p class="title">Header</p>
        <nav>
          <ul>
            <li><a href="">Главная</a></li>
            <li><a href="">Статьи</a></li>
            <li><a href="">Новости</a></li>
          </ul>
        </nav>
      </header>
