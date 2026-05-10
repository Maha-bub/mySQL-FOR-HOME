<?php
/* ============================================================
   school-bags.php
   ✏️ Edit only the variables below — do NOT touch anything else
   ============================================================ */

$page_title    = "School Bags - Esho Desh Gori";
$project_badge = "Education";
$project_icon  = "fas fa-backpack";
$project_color = "linear-gradient(135deg,#1a3a5c,#3b82c4)";
$project_title = "School Bags";
$project_intro = "Giving every child the tools they need to learn and grow.";

// ✏️ To add a real image: put file in assets/images/projects/ then write path here
$project_image = ''; // e.g. '../assets/images/projects/school-bags.jpg'

$raised = "৳72,000";
$goal   = "৳1,00,000";
$pct    = "72"; // number only, no %

$description = [
  "In Bangladesh, millions of children from underprivileged families cannot afford basic school supplies. Without proper materials, many are forced to drop out before completing primary education.",
  "Our School Bags project provides fully stocked school bags — filled with notebooks, pens, pencils, erasers, a ruler, and other essentials. Each bag is prepared to support a full academic year.",
  "Since 2019, we have distributed over 5,000 school bags across 12 districts. Your donation of just ৳500 equips one child for an entire year.",
];

$impact = [
  ["icon" => "fas fa-child",         "text" => "5,000+ children supported"],
  ["icon" => "fas fa-map-marker-alt","text" => "12 districts covered"],
  ["icon" => "fas fa-calendar",      "text" => "Running since 2019"],
  ["icon" => "fas fa-coins",         "text" => "৳500 equips one child/year"],
];

include '_project-template.php';
