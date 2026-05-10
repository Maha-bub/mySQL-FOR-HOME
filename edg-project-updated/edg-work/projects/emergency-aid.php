<?php
$page_title    = "Emergency Aid - Esho Desh Gori";
$project_badge = "Emergency";
$project_icon  = "fas fa-hand-holding-heart";
$project_color = "linear-gradient(135deg,#4a0a1a,#e11d48)";
$project_title = "Emergency Aid";
$project_intro = "When disaster strikes, we respond within hours.";
$project_image = ''; // '../assets/images/projects/emergency-aid.jpg'
$raised = "৳85,000"; $goal = "৳1,00,000"; $pct = "85";
$description = [
  "Bangladesh is one of the most disaster-prone countries in the world. Floods, cyclones, fires, and landslides displace millions of families every year — leaving them with nothing overnight.",
  "Our Emergency Aid team mobilises within hours of a disaster. We distribute food packs, clean water, medicine, warm blankets, and hygiene kits to affected families on the ground.",
  "Your donation to the Emergency Aid fund stays ready year-round so we can respond immediately — without waiting for approvals or bureaucracy.",
];
$impact = [
  ["icon" => "fas fa-bolt",         "text" => "Response within hours"],
  ["icon" => "fas fa-box",          "text" => "20,000+ relief kits given"],
  ["icon" => "fas fa-map-marked-alt","text" => "All flood-prone districts"],
  ["icon" => "fas fa-users",        "text" => "50,000+ people reached"],
];
include '_project-template.php';
