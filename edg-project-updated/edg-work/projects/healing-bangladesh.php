<?php
$page_title    = "Healing Bangladesh - Esho Desh Gori";
$project_badge = "Healthcare";
$project_icon  = "fas fa-heart-pulse";
$project_color = "linear-gradient(135deg,#0a3d3a,#0d9488)";
$project_title = "Healing Bangladesh";
$project_intro = "Bringing free healthcare to those who need it most.";
$project_image = ''; // '../assets/images/projects/healing-bangladesh.jpg'
$raised = "৳63,000"; $goal = "৳1,00,000"; $pct = "63";
$description = [
  "Millions of Bangladeshis in rural areas have no access to basic healthcare. Travelling to a clinic can cost more than a week's wages — so most people suffer in silence.",
  "Our Healing Bangladesh project deploys mobile medical camps to remote villages, providing free doctor consultations, medicine, diagnostic tests, and referrals to hospitals when needed.",
  "Each camp serves 300–500 patients in a single day. We also run dedicated mother and child health sessions to reduce infant mortality in underserved communities.",
];
$impact = [
  ["icon" => "fas fa-stethoscope",   "text" => "10,000+ patients treated"],
  ["icon" => "fas fa-map-marker-alt","text" => "20+ remote locations"],
  ["icon" => "fas fa-pills",         "text" => "Free medicine distributed"],
  ["icon" => "fas fa-baby",          "text" => "Mother & child programs"],
];
include '_project-template.php';
