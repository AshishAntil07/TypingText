<?php

require 'vendor/autoload.php';

use SVG\SVG;
use SVG\Nodes\Shapes\SVGLine;

// Setup the document
$image = new SVG(100, 100);
$doc = $image->getDocument();

// Create a small red horizontal line
$line = new SVGLine(20, 20, 60, 20);
$line->setStyle('stroke', '#ff0000');
$doc->addChild($line);

// Add the proper header and echo the SVG
header('Content-Type: image/svg+xml');
echo $image;
?>
