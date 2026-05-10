<?php
$page_title    = "Feed Daily - Esho Desh Gori";
$project_badge = "Food";
$project_icon  = "fas fa-bowl-food";
$project_color = "linear-gradient(135deg,#1a3a10,#4a8c20)";
$project_title = "Feed Daily";
$project_intro = "No one should go to bed hungry in our country.";
$project_image = ''; // '../assets/images/projects/feed-daily.jpg'
$raised = "৳77,000"; $goal = "৳1,00,000"; $pct = "77";
$description = [
  "Hunger is a silent crisis in Bangladesh. Thousands of elderly, disabled, and day labourers go without food every single day — invisible and forgotten.",
  "Our Feed Daily program provides hot, nutritious meals to the most vulnerable. ৳30 feeds one person for a full day. ৳900 keeps someone fed for an entire month.",
  "We currently run daily feeding at 5 distribution points across Dhaka and Chittagong, serving over 500 meals per day — 365 days a year.",
];
$impact = [
  ["icon" => "fas fa-bowl-food","text" => "500+ meals served daily"],
  ["icon" => "fas fa-coins",    "text" => "৳30 feeds one person/day"],
  ["icon" => "fas fa-calendar", "text" => "365 days a year"],
  ["icon" => "fas fa-heart",    "text" => "Zero hunger, zero waste"],
];
include '_project-template.php';
