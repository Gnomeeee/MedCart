-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 06:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medcart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `profile_pic` varchar(255) DEFAULT NULL,
  `admin_id` int(3) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_fname` varchar(20) NOT NULL,
  `admin_lname` varchar(20) NOT NULL,
  `admin_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`profile_pic`, `admin_id`, `admin_email`, `admin_fname`, `admin_lname`, `admin_password`) VALUES
('ngi.jpg', 13, 'admin@gmail.com', 'marion', 'beri', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `purchased` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `item_id`, `quantity`, `created_at`, `purchased`) VALUES
(72, 118, 157, 1, '2025-05-13 00:16:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(5) NOT NULL,
  `item_title` varchar(250) NOT NULL,
  `item_brand` varchar(250) NOT NULL,
  `item_cat` varchar(15) NOT NULL,
  `item_details` text NOT NULL,
  `item_tags` varchar(250) NOT NULL,
  `item_image` varchar(250) NOT NULL,
  `item_quantity` int(3) NOT NULL,
  `item_price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_title`, `item_brand`, `item_cat`, `item_details`, `item_tags`, `item_image`, `item_quantity`, `item_price`) VALUES
(102, 'Alaxan FR 200mg/325mg Capsule - 20s', 'Southstar drugs', 'Choose...', 'Ibuprofen Paracetamol 200 mg 325 mg Analgesics (Non - Opioid) Non - Steroidal Anti - Inflammatory 20 pcs', 'Alaxan FR contains the synergistic combination of ibuprofen and paracetamol in a capsule. The inflammatory activity of ibuprofen and paracetamol combination is greater compared to the individual ingredients. Because pain is usually accompanied by inf', 'Alaxan FR 200mg-325mg Capsule - 20s.webp', 100, 136),
(103, 'Alciflora 2 Billion CFU-5ml Suspension - 5ml', 'Southstar drugs', 'medicine/Treatm', 'Adults: 2-3 mini bottles a day Children: 1-2 mini bottles a day Shake the mini bottle before use. To open the mini bottle, rotate the upper part and detach it. Take the content as such or dilute it in sweetened water, milk, tea, orange juice. Once opened consume within a short period to avoid contamination of the suspension. Take regular intervals during the day This is for oral use only. Do not inject or administer in any other way', 'ALCIFLORA is a preparation consisting of a suspension of Bacillus clausii spores, normal inhabitants of the intestine, with no pathogenic properties. This helps in the recovery of the intestinal microbial flora imbalance of diverse origin.', 'Alciflora 2 Billion CFU-5ml Suspension - 5ml.webp', 100, 45),
(104, 'Aveeno Skin Relief Moisturizing Lotion 71ml', 'Southstar drugs', 'Personal Care', 'Instantly Moisturizes for 24 hours with lasting protection against dryness. Dermatologist Recommended Brand 71ml', 'Aveeno Skin Relief Moisturizing Lotion is rich yet fast absorbing and starts to work immediately to nourish and restore essential moisture, so your skin feels softer and healthier.', 'Aveeno Skin Relief Moisturizing Lotion 71ml.webp', 100, 227),
(105, 'Axe Ice Chill Deodorant Roll On 40ml', 'Southstar drugs', 'Personal Care', '48hr antiperspirant', '48hr antiperspirant', 'Axe Ice Chill Deodorant Roll On 40ml.webp', 92, 175),
(106, 'Axe Spray Ice Breaker 135ml', 'Southstar drugs', 'Personal Care', 'N/a', 'N/a', 'Axe Spray Ice Breaker 135ml.webp', 99, 282),
(107, 'Babyflo Bottle Sponge with Nipple Brush', 'Southstar drugs', 'Baby & Kid Care', 'Bottle Sponge with Nipple Brush Ideal for cleaning hard-to-reach corners of baby feeding bottle.  With plastic handle for easy cleaning. 1 pc', 'Babyflo', 'Babyflo Bottle Sponge with Nipple Brush.webp', 99, 76),
(108, 'Babyflo Feeding Bottle Nursery 2oz', 'Southstar drugs', 'Baby & Kid Care', 'Feeding Bottle Nursery 2oz', 'Babyflo', 'Babyflo Feeding Bottle Nursery 2oz.webp', 100, 88),
(109, 'Babyflo Gentle Cotton Buds Plastic Stems 108 Tips', 'Southstar drugs', 'Baby & Kid Care', 'Unbreakable Safe Plastic Stems 108 Tips', 'Babyflo Gentle Cotton Buds Plastic Stems is a trusted heritage brand that offers a range of high-quality cotton buds products at affordable prices. With serrated plastic stems for better grip. It also comes in resealable plastic pouch.', 'Babyflo Gentle Cotton Buds Plastic Stems 108 Tips.webp', 100, 17),
(110, 'Babyflo Nasal Aspirator', 'Southstar drugs', 'Baby & Kid Care', 'N/a', 'Nasal', 'Babyflo Nasal Aspirator.webp', 100, 91),
(111, 'Bactidol 1.2 mg - 600 mcg Orange Lozenges - 8s', 'Southstar drugs', 'medicine/Treatm', 'Dichlorobenzyl Alcohol + Amylmetacresol 1.2 mg / 600 mcg Provides flavorful and convenient relief from-a Sore Throat 1 pack / 8 lozenges', 'Bactidol', 'Bactidol 1.2 mg - 600 mcg Orange Lozenges - 8s.webp', 99, 73),
(112, 'Bactidol 120ml Oral Antiseptic', 'Southstar drugs', 'medicine/Treatm', 'Symptomatic relief of mouth & throat infections including mouth ulcers caused by susceptible bacteria & fungi. Hexetidine 120ml 0.01% Solution 1 pc', 'Bactidol', 'Bactidol 120ml Oral Antiseptic.webp', 100, 248),
(113, 'Bactidol 250ml Oral Antiseptic', 'Southstar drugs', 'medicine/Treatm', 'Hexetidine (Bactidol®) permeates the mucous membranes, preventing further development of bacteria and fungi.  Hexetidine 250 ml 0.01% Solution Mouth / Throat Preparation 1 pc Seni', 'Bactidol', 'Bactidol 250ml Oral Antiseptic.webp', 100, 362),
(114, 'Bactidol 500ml Oral Antiseptic', 'Southstar drugs', 'medicine/Treatm', 'Hexetidine (Bactidol®) permeates the mucous membranes, preventing further development of bacteria and fungi.  Hexetidine 250 ml 0.01% Solution Mouth / Throat Preparation 1 pc Seni', 'Bactidol', 'Bactidol 500ml Oral Antiseptic.webp', 100, 724),
(115, 'Belo Intense White Deodorant Roll-On 40ml', 'Southstar drugs', 'Personal Care', 'Penetrates deeply to whiten discoloration at the cellular level Prevents skin inflammation caused by habitual plucking, shaving, or waxing Fights sweat and body odor for up to 48 hours Alcohol-free. Paraben-free. Hypoallergenic. Dermatologist-tested.', 'Belo', 'Belo Intense White Deodorant Roll-On 40ml.webp', 100, 174),
(116, 'Belo Intensive Whitening Lotion 200ml', 'Southstar drugs', 'Personal Care', 'A luxurious moisture-rich body lotion with the powerful combination of Kojic Acid and Tranexamic Acid that intensively whitens skin.• SPF 30 further protects against harmful UVA and UVB rays.   Expertly formulated Hypoallergenic Dermatologist-tested 200ml', 'Belo', 'Belo Intensive Whitening Lotion 200ml.webp', 100, 292),
(117, 'Bench Eight Body Spray 75ml', 'Southstar drugs', 'Personal Care', 'Body Spray 75 ml', 'Bench', 'Bench Eight Body Spray 75ml.webp', 100, 104),
(118, 'Berocca Immuno Effervescent Tablets Triple Action - 30s', 'Southstar drugs', 'medicine/Treatm', 'Ascorbic acid', 'Berocca', 'Berocca Immuno Effervescent Tablets Triple Action - 30s.webp', 100, 478),
(119, 'Betadine Throat Spray 50ml', 'Southstar drugs', 'medicine/Treatm', 'Help kills 99.99% of sore-throat causing viruses in as early as 30 seconds Helps relieve 7 signs and symptoms of a sore throat 5 benefits in 1 - Scientifically demonstrated to kill common viruses, bacteria, fungi, spores and microscopic parasites that causes sore', 'Betadine', 'Betadine Throat Spray 50ml.webp', 100, 631),
(120, 'Bioflu 10mg  2mg  500mg Tablet - 20s', 'Southstar drugs', 'Choose...', 'Phenylephrine HCI, Chlorpehenamine Maleate, Paracetamol 10 mg / 2 mg / 500 mg 20 tablets Used for the relief of clogged nose, runny nose, postnasal drip, itchy and watery eyes, sneezing, headache, body aches, and fever associated with flu, the common cold, allergic rhinitis, sinusitis, and other minor respiratory tract infections.', 'Bioflu® provides relief from the multiple symptoms of flu such as fever, body pain, joint pain, colds, chills, cough and sore throat (from post-nasal drip).', 'Bioflu 10mg  2mg  500mg Tablet - 20s.webp', 100, 170),
(121, 'Biogesic 500mg Caplet - 20s', 'Paracetamol', 'medicine/Treatm', 'Paracetamol 500 mg Used for relief of minor aches, pains & fever reduction 20 pcs caplet', 'Biogesic is used and trusted for headache and fever relief. It can be consumed on an empty stomach, and can be taken by pregnant women, breastfeeding moms and the elderly.', 'Biogesic 500mg Caplet - 20s.webp', 99, 85),
(122, 'Bonamine 25 mg Chewable Tablet - 20s', 'Southstar drugs', 'medicine/Treatm', 'Meclizine HCl 25 mg Chewables Anti - Emetic / Anti - Vertigo 20 pcs tablet', 'INDICATIONS: Treatment of nausea, vomiting, or vertigo (dizziness) due to motion sickness CONTRA INDICATIONS: Pregnancy PRECAUTIONS: Glaucoma, prostatic enlargement, avoid driving a car or machinery SIDE EFFECTS: Drowsiness, dry mouth, vomiting DRUG ', 'Bonamine 25 mg Chewable Tablet - 20s.webp', 100, 290),
(123, 'Bonamine Candy Flavored Tablet 25mg - 5s', 'Southstar drugs', 'medicine/Treatm', 'Meclizine HCI 25mg Anti-emetic / anti-vertigo Candy flavored 5 Chewable tablets', 'Meclizine', 'Bonamine Candy Flavored Tablet 25mg - 5s.webp', 98, 70),
(124, 'Calci-Aid Calcium Supplement Soft Gel Capsules - 30s', 'Southstar drugs', 'medicine/Treatm', 'Calcium Carbonate Multivitamin that helps build strong bones and fights osteoporosis Calci-aid, a calcium supplement, promotes Bone Health and Helps fight Osteoporosis 1 Pack / Soft Gel Capsule', 'Prevent and treat osteoporosis, calcium malabsorption and deficiency conditions. Inadequate calcium intake can lead to osteoporosis, a disease where bones became fragile and brittle. Stooped posture and height reduction can result. Taken daily, it su', 'Calci-Aid Calcium Supplement Soft Gel Capsules - 30s.webp', 100, 348),
(125, 'Caltrate Advance Cholecalciferol + Minerals Tablets - 30s', 'Southstar drugs', 'medicine/Treatm', 'Caltrate Advance Cholecalciferol + Minerals 30 Tablets', 'Helps prevent stooped posture and bone mass loss resulting to fractures and bone breakage Helps prevent Osteoporosis Related to: calcium d-glucarate,calcium chloride,coral calcium,calcium carbonate,calcium gummies,calcium magnesium,calcium citrate,ca', 'Caltrate Advance Cholecalciferol + Minerals Tablets - 30s.webp', 99, 263),
(126, 'Caltrate Advance Cholecalciferol + Minerals Tablets - 60s', 'Southstar drugs', 'medicine/Treatm', 'Helps prevent stooped posture and bone mass loss resulting to fractures and bone breakage Helps prevent Osteoporosis Related to: calcium d-glucarate,calcium chloride,coral calcium,calcium carbonate,calcium gummies,calcium magnesium,calcium citrate,calcium gummy,calcium chews,calcium citrate chewable,vitamin d gummies,calcium supplement,collagen,chewable vitamin,calcium', 'Caltrate Advance', 'Caltrate Advance Cholecalciferol + Minerals Tablets - 60s.webp', 100, 511),
(127, 'Casino Ethyl Alcohol 150ml', 'Southstar drugs', 'Personal Care', 'Ethyl Alcohol 70% solution 150ml', 'Ethyl Alcohol', 'Casino Ethyl Alcohol 150ml.webp', 98, 38),
(128, 'Centrum Kids Vitamins + Zinc Gummies - 15s', 'Southstar drugs', 'Baby & Kid Care', 'Apple flavor Contains Vitamins A,B6, C, D, & E + Zinc', 'Centrum kids', 'Centrum Kids Vitamins + Zinc Gummies - 15s.webp', 100, 135),
(129, 'Cetaphil Baby Lotion 50ml', 'Cetaphil', 'Baby & Kid Care', 'Preserves skin barrier Hypoallergenic Contains glycerin', 'Baby Lotion', 'Cetaphil Baby Lotion 50ml.webp', 99, 153),
(130, 'Cetaphil Baby With Organic Calendula Daily Lotion 400ml', 'Cetaphil', 'Baby & Kid Care', 'Soothe and nourish your baby\'s delicate skin', 'Baby Lotion', 'Cetaphil Baby With Organic Calendula Daily Lotion 400ml.webp', 100, 671),
(131, 'Cetaphil Gentle Skin Cleanser, 250 ml', 'Cetaphil', 'Personal Care', '250 ml', 'Lotion', 'Cetaphil Gentle Skin Cleanser, 250 ml.jpeg', 99, 358),
(132, 'Cetaphil Sun SPF50 Light Gel 50ml', 'Cetaphil', 'Personal Care', 'N/a', 'Lotion', 'Cetaphil Sun SPF50 Light Gel 50ml.webp', 100, 332),
(133, 'Cetirizine 10mg Tablet - 30s', 'Southstar drugs', 'Medicine/Treatm', '10mg', 'Cetirizine', 'Cetirizine 10mg Tablet - 30s.webp', 100, 153),
(134, 'Cherifer 120ml Syrup', 'Southstar drugs', 'Baby & Kid Care', '120ml Syrup', 'Cherifer', 'Cherifer 120ml Syrup.webp', 99, 345),
(135, 'Clear Men Anti Dandruff Shampoo Cool Sport Menthol 170ML', 'Head & Shoulders', 'Personal Care', 'Cool Sport Menthol 170ml', 'Shampoo', 'Clear Men Anti Dandruff Shampoo Cool Sport Menthol 170ML.webp', 99, 321),
(136, 'Colgate Sensitive Plus Anticavity Toothpaste, 70 mg', 'Colgate', 'Personal Care', '70 mg', 'Toothpaste', 'Colgate Sensitive Plus Anticavity Toothpaste, 70 gm.png', 99, 186),
(137, 'Decolgen Forte 25mg-2mg-500mg Caplet - 20s', 'Southstar drugs', 'medicine/Treatm', 'Phenylpropanolamine HCI + Chlorphenamine Maleate + Paracetamol 25mg/2mg/500 mg Nasal Decongestant Antihistamine Analgesic Cough & Cold Preparation 20 Caplets', 'Decolgen Forte used for the relief of clogged nose, postnasal drip, headache, body aches, and fever associated with the common cold, sinusitis, flu, and other minor respiratory tract infections. It also helps decongest sinus openings and passages.', 'Decolgen Forte 25mg-2mg-500mg Caplet - 20s.webp', 98, 120),
(138, 'Diatabs 2 mg Capsule - 20s', 'Loperamide', 'Medicine/Treatm', '2 mg Antidiarrheals Antimotility 20 pcs capsule', 'Capsule', 'Diatabs 2 mg Capsule - 20s.webp', 99, 160),
(139, 'Diatabs Advance Softgel Capsule 8mg - 10s', 'Loperamide', 'Medicine/Treatm', 'Product Content & Action:   Loperamide (2mg) : Anti Diarrheal Slows down intestinal movement resulting in improved stool consistency  Simeticone (125mg) : Antiflatulent Relieves bloating and gassiness in the gastrointestinal tract', 'The combination of Loperamide and Simeticone provides faster relief of both diarrhea and associated gas-related abdominal pain, cramps and bloating than Loperamide or Simeticone alone.', 'Diatabs Advance Softgel Capsule 8mg - 10s.webp', 98, 190),
(140, 'Dove Bar White 100g', 'Dove', 'Personal Care', 'Classic moisturizing formula that cleanses and moisturizes at the same time Dove doesnt dry skin like ordinary soaps can ¼ moisturising cream and mild cleansers help retain skins moisture Leaves skin softer, smoother and healthier-looking Suitable for daily use on face, body and hands 100 g', 'Dove Bar White', 'Dove Bar White 100g.webp', 100, 73),
(141, 'Dove Deodorant Dry Serum Collagen Intensive Renew Omega 6 50ML', 'Dove', 'Personal Care', 'Dry Serum Collagen', 'Dove Deodorant Dry Serum Collagen Intensive Renew Omega 6', 'Dove Deodorant Dry Serum Collagen Intensive Renew Omega 6 50ML.webp', 99, 187),
(142, 'Dove Deodorant Roll-On Original 25ML', 'Dove', 'Personal Care', 'Roll-on', 'Deodorant', 'Dove Deodorant Roll-On Original 25ML.webp', 98, 112),
(143, 'Dove Men Deodorant Roll-On Invisible Dry 40ML', 'Dove', 'Personal Care', 'Roll-On Invisible Dry', 'Deodorant', 'Dove Men Deodorant Roll-On Invisible Dry 40ML.webp', 98, 236),
(144, 'Dove Men Deodorant Spray Invisible Dry 150ML', 'Dove', 'Personal Care', 'Deodorant Spray Invisible Dry', 'Deodorant', 'Dove Men Deodorant Spray Invisible Dry 150ML.webp', 100, 489),
(147, 'Enervon Z+ Film-Coated Tablet - 20s', 'Enervon', 'Medicine/Treatm', 'Film-Coated Tablet', 'Enervon', 'Enervon Z+ Film-Coated Tablet - 20s.webp', 100, 135),
(148, 'EQ Dry Newborn - 22s', 'EQ', 'Baby & Kid Care', 'Newborn Baby', 'Diaper', 'EQ Dry Newborn - 22s.webp', 100, 222),
(149, 'EQ Pants Diaper XXXL - 40s', 'EQ', 'Baby & Kid Care', 'XXXL', 'Diaper', 'EQ Pants Diaper XXXL - 40s.webp', 99, 678),
(150, 'EQ Pants XXL 40s', 'EQ', 'Baby & Kid Care', 'XXL', 'Diaper', 'EQ Pants XXL 40s.webp', 100, 489),
(151, 'Erceflora Gut Defense Suspension 2b-5ml - 5s', 'Erceflora', 'Medicine/Treatm', '5ML', 'Erceflora Gut Defense', 'Erceflora Gut Defense Suspension 2b-5ml - 5s.webp', 99, 103),
(152, 'Fern C Plus 500 gm - 10mg Capsule - 10s', 'Fern', 'Medicine/Treatm', '500 gm', 'Vitamin C', 'Fern C Plus 500 gm - 10mg Capsule - 10s.webp', 99, 221),
(153, 'Fiona Cologne Raspberry 50ml', 'Fiona', 'Personal Care', '50ml', 'Cologne', 'Fiona Cologne Raspberry 50ml.webp', 100, 89),
(154, 'Fiona Cologne Rosy Red 100ml', 'Fiona', 'Personal Care', '100ML', 'Cologne', 'Fiona Cologne Rosy Red 100ml.webp', 100, 179),
(155, 'Flanax Forte 550mg Tablet - 15s', 'Flanax', 'Medicine/Treatm', '550mg', 'Tablet', 'Flanax Forte 550mg Tablet - 15s.webp', 99, 224),
(156, 'Green Cross Total Defense Sanitizer pump 300ml', 'Green Cross', 'Personal Care', '300ML', 'Sanitizer', 'Green Cross Total Defense Sanitizer pump 300ml.webp', 98, 345),
(157, 'Grips Hair Clay 25 g', 'Grips', 'Personal Care', '25g', 'Hair clay', 'Grips Hair Clay 25 g.webp', 100, 68),
(158, 'Grips Hair Pomade Wax 75 g', 'Grips', 'Personal Care', '75g', 'Pomade Wax', 'Grips Hair Pomade Wax 75 g.webp', 100, 138),
(159, 'Grips Hair Wax Hard and Mat 75 g', 'Grips', 'Personal Care', '75g', 'Wax Hard and Mat', 'Grips Hair Wax Hard and Mat 75 g.webp', 100, 156),
(160, 'Grips Hair Wax Hard and Shiny 75 g', 'Grips', 'Personal Care', '75g', 'Wax Har and Shiny', 'Grips Hair Wax Hard and Shiny 75 g.webp', 99, 163),
(161, 'Happy Baby Pants Ultra Dry Diaper Large 24s', 'Happy', 'Baby & Kid Care', 'Large 24s', 'Ultra Dry Diaper', 'Happy Baby Pants Ultra Dry Diaper Large 24s.webp', 99, 512),
(162, 'Head & Shoulders Cool Menthol Shampoo 170ml', 'Head & Shoulders', 'Personal Care', '170ml', 'Menthol Shampoo', 'Head & Shoulders Cool Menthol Shampoo 170ml.webp', 100, 275),
(163, 'Head & Shoulders Old Spice Shampoo 170ml', 'Head & Shoulders', 'Personal Care', '170ml', 'Old Spice Shampoo', 'Head & Shoulders Old Spice Shampoo 170ml.webp', 100, 286),
(164, 'Immunpro 500mg - 10mg Tablet - 20s', 'Southstar drugs', 'Medicine/Treatm', '500mg/10mg', 'Tablet', 'Immunpro 500mg - 10mg Tablet - 20s.webp', 100, 111),
(165, 'Kremil S Tablet - 20s', 'Kremil S', 'Medicine/Treatm', '20s', 'Tablet', 'Kremil S Tablet - 20s.webp', 100, 68),
(166, 'Lactacyd Baby Gentle Care Body and Hair Wash 150ml', 'Southstar drugs', 'Baby & Kid Care', '150ml', 'Body and Hair Wash', 'Lactacyd Baby Gentle Care Body and Hair Wash 150ml.webp', 98, 214),
(167, 'Limcee Vitamin C 500 mg Orange Flavour Chewable, 15 Tablets', 'Limcee', 'Medicine/Treatm', '500 mg 15 tablets', 'Vitamin C', 'Limcee Vitamin C 500 mg Orange Flavour Chewable, 15 Tablets.jpeg', 99, 140),
(168, 'Megan Nose Pore Strips Volcanic Ash Extract - 4s', 'Megan', 'Personal Care', '4s', 'Nose Strips', 'Megan Nose Pore Strips Volcanic Ash Extract - 4s.webp', 100, 63),
(169, 'Megan Nose Pore Strips Witch Hazel Extracts - 4s', 'Megan', 'Personal Care', '4s', 'Nose Strips', 'Megan Nose Pore Strips Witch Hazel Extracts - 4s.webp', 99, 78),
(170, 'Megan Poreless White Sunflower Face & Body SPF15 Sunscreen Lotion 50ml', 'Megan', 'Personal Care', '50ml', 'Lotion', 'Megan Poreless White Sunflower Face & Body SPF15 Sunscreen Lotion 50ml.webp', 100, 348),
(171, 'Nivea Healthy Glow Dewy Sakura Lotion 200ml', 'Nivea', 'Personal Care', '200ml', 'Lotion', 'Nivea Healthy Glow Dewy Sakura Lotion 200ml.webp', 100, 367),
(172, 'Nursy Baby Wipes Unscented - 90s', 'Nursy', 'Baby & Kid Care', '90s', 'Wipes', 'Nursy Baby Wipes Unscented - 90s.webp', 100, 48),
(173, 'Old Spice Bear Glove Refresh Body Spray 106 Grams', 'Old Spice', 'Personal Care', '106grams', 'Body Spray', 'Old Spice Bear Glove Refresh Body Spray 106 Grams.webp', 99, 256),
(174, 'Old Spice Deo High Endurance Pure Sport Dry Cream 14 g', 'Old Spice', 'Personal Care', '14g', 'Deodorant', 'Old Spice Deo High Endurance Pure Sport Dry Cream 14 g.webp', 99, 154),
(175, 'Palmolive Naturals Intensive Moisture Shampoo 180ml', 'Palmolive', 'Personal Care', '180ml', 'Shampoo', 'Palmolive Naturals Intensive Moisture Shampoo 180ml.webp', 100, 189),
(176, 'Palmolive Naturals Silky Straight Conditioner & Shampoo 90ml', 'Palmolive', 'Personal Care', '90ml', 'Shampoo', 'Palmolive Naturals Silky Straight Conditioner & Shampoo 90ml.webp', 100, 156),
(177, 'Pampers Baby Dry Diaper Pants XXXL- 22s', 'Pampers', 'Baby & Kid Care', '22s', 'Diaper', 'Pampers Baby Dry Diaper Pants XXXL- 22s.webp', 99, 345),
(178, 'Pampers Baby Dry Newborn Diaper 40s', 'Pampers', 'Baby & Kid Care', '40s', 'Diaper', 'Pampers Baby Dry Newborn Diaper 40s.webp', 99, 465),
(179, 'Pampers Baby Dry Pants Diaper Large - 58s', 'Pampers', 'Baby & Kid Care', '58s', 'Diaper', 'Pampers Baby Dry Pants Diaper Large - 58s.webp', 99, 789),
(180, 'Pampers Baby Dry Pants Diaper XL - 26s', 'Pampers', 'Baby & Kid Care', '26s', 'Diaper', 'Pampers Baby Dry Pants Diaper XL - 26s.webp', 100, 512),
(181, 'Pampers Overnight Pants Value Large 30s', 'Pampers', 'Baby & Kid Care', '30s', 'Diaper', 'Pampers Overnight Pants Value Large 30s.webp', 99, 389),
(182, 'Pampers Overnight Pants Value XL 26s', 'Pampers', 'Baby & Kid Care', '26s', 'Diaper', 'Pampers Overnight Pants Value XL 26s.webp', 100, 356),
(183, 'Safeguard Deo Stick Advance Active Fresh 45g', 'Safeguard', 'Personal Care', '45g', 'Deodorant', 'Safeguard Deo Stick Advance Active Fresh 45g.webp', 98, 168),
(184, 'Sangobion Iron Plus Capsule - 20s', 'Sangobion', 'Medicine/Treatm', '20s', 'Capsule', 'Sangobion Iron Plus Capsule - 20s.webp', 99, 99),
(185, 'Johnsons Baby Lotion Milk and Rice 200ml', 'Johnsons', 'Baby & Kid Care', 'Baby Powder', 'Powder', 'Johnsons Baby Lotion Milk and Rice 200ml.webp', 99, 125),
(186, 'Tokyo White Whitening Tinted Sunscreen 10ml', 'Tokyo White', 'Personal Care', '10ml', 'Whitening sunscreen', 'Tokyo White Whitening Tinted Sunscreen 10ml.webp', 100, 289),
(187, 'Johnsons Bath Milk plus Oat 200ml', 'Johnsons', 'Baby & Kid Care', 'for new born baby', 'Baby soap', 'Johnsons Bath Milk plus Oat 200ml.webp', 100, 368);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unseen','seen') DEFAULT 'unseen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `staff_id`, `message`, `created_at`, `status`) VALUES
(21, 34, 'A new order has been placed by customer ID: 118 on 2025-05-12.', '2025-05-12 16:16:56', 'seen'),
(22, 38, 'A new order has been placed by customer ID: 118 on 2025-05-12.', '2025-05-12 16:16:56', 'seen');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `seen`, `created_at`) VALUES
(10, 25, 'Order #265 for Unknown Customer has been delivered.', 0, '2025-04-20 15:45:47'),
(11, 22, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:46:01'),
(12, 25, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:46:01'),
(13, 22, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:54:21'),
(14, 25, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:54:21'),
(15, 22, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:56:43'),
(16, 25, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:56:43'),
(17, 22, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:58:41'),
(18, 25, 'Order #3 for Unknown Customer has been delivered.', 0, '2025-04-22 13:58:41'),
(19, 22, 'Order #4 for Unknown Customer has been delivered.', 0, '2025-04-22 14:06:14'),
(20, 25, 'Order #4 for Unknown Customer has been delivered.', 0, '2025-04-22 14:06:14'),
(21, 25, 'Order #7 for Unknown Customer has been delivered.', 0, '2025-04-22 15:05:12'),
(22, 29, 'Order #7 for Unknown Customer has been delivered.', 0, '2025-04-22 15:05:12'),
(23, 25, 'Order #8 for Unknown Customer has been delivered.', 0, '2025-04-22 15:07:47'),
(24, 29, 'Order #8 for Unknown Customer has been delivered.', 0, '2025-04-22 15:07:47'),
(25, 25, 'Order #9 for Unknown Customer has been delivered.', 0, '2025-04-22 15:08:22'),
(26, 29, 'Order #9 for Unknown Customer has been delivered.', 0, '2025-04-22 15:08:22'),
(27, 25, 'Order #11 for Unknown Customer has been delivered.', 0, '2025-04-22 22:33:27'),
(28, 29, 'Order #11 for Unknown Customer has been delivered.', 0, '2025-04-22 22:33:27'),
(29, 25, 'Order #12 for Unknown Customer has been delivered.', 0, '2025-04-23 19:42:52'),
(30, 29, 'Order #12 for Unknown Customer has been delivered.', 0, '2025-04-23 19:42:52'),
(31, 25, 'Order #17 for Unknown Customer has been delivered.', 0, '2025-04-23 20:23:08'),
(32, 29, 'Order #17 for Unknown Customer has been delivered.', 0, '2025-04-23 20:23:08'),
(33, 25, 'Order #18 for Unknown Customer has been delivered.', 0, '2025-04-23 23:27:45'),
(34, 29, 'Order #18 for Unknown Customer has been delivered.', 0, '2025-04-23 23:27:45'),
(35, 34, 'Order #18 for Unknown Customer has been delivered.', 0, '2025-04-23 23:27:45'),
(36, 25, 'Order #19 for Unknown Customer has been delivered.', 0, '2025-04-23 23:38:22'),
(37, 29, 'Order #19 for Unknown Customer has been delivered.', 0, '2025-04-23 23:38:22'),
(38, 34, 'Order #19 for Unknown Customer has been delivered.', 0, '2025-04-23 23:38:22'),
(39, 25, 'Order #20 for Unknown Customer has been delivered.', 0, '2025-04-23 23:53:21'),
(40, 29, 'Order #20 for Unknown Customer has been delivered.', 0, '2025-04-23 23:53:21'),
(41, 34, 'Order #20 for Unknown Customer has been delivered.', 0, '2025-04-23 23:53:21'),
(42, 25, 'Order #23 for Unknown Customer has been delivered.', 0, '2025-04-23 23:58:53'),
(43, 29, 'Order #23 for Unknown Customer has been delivered.', 0, '2025-04-23 23:58:53'),
(44, 34, 'Order #23 for Unknown Customer has been delivered.', 0, '2025-04-23 23:58:53'),
(45, 25, 'Order #26 for Unknown Customer has been delivered.', 0, '2025-04-24 08:06:55'),
(46, 29, 'Order #26 for Unknown Customer has been delivered.', 0, '2025-04-24 08:06:55'),
(47, 34, 'Order #26 for Unknown Customer has been delivered.', 0, '2025-04-24 08:06:55'),
(48, 25, 'Order #27 for Unknown Customer has been delivered.', 0, '2025-04-24 08:27:17'),
(49, 29, 'Order #27 for Unknown Customer has been delivered.', 0, '2025-04-24 08:27:17'),
(50, 34, 'Order #27 for Unknown Customer has been delivered.', 0, '2025-04-24 08:27:17'),
(51, 25, 'Order #28 for Unknown Customer has been delivered.', 0, '2025-04-24 08:38:05'),
(52, 29, 'Order #28 for Unknown Customer has been delivered.', 0, '2025-04-24 08:38:05'),
(53, 34, 'Order #28 for Unknown Customer has been delivered.', 0, '2025-04-24 08:38:05'),
(54, 25, 'Order #32 for Unknown Customer has been delivered.', 0, '2025-04-24 09:10:23'),
(55, 29, 'Order #32 for Unknown Customer has been delivered.', 0, '2025-04-24 09:10:23'),
(56, 34, 'Order #32 for Unknown Customer has been delivered.', 0, '2025-04-24 09:10:23'),
(57, 25, 'Order #33 for Unknown Customer has been delivered.', 0, '2025-04-24 09:21:31'),
(58, 29, 'Order #33 for Unknown Customer has been delivered.', 0, '2025-04-24 09:21:31'),
(59, 34, 'Order #33 for Unknown Customer has been delivered.', 0, '2025-04-24 09:21:31'),
(60, 25, 'Order #34 for Unknown Customer has been delivered.', 0, '2025-05-02 12:15:16'),
(61, 34, 'Order #34 for Unknown Customer has been delivered.', 0, '2025-05-02 12:15:16'),
(62, 36, 'Order #34 for Unknown Customer has been delivered.', 0, '2025-05-02 12:15:16'),
(63, 34, 'Order #35 for Unknown Customer has been delivered.', 0, '2025-05-02 13:58:49'),
(64, 38, 'Order #35 for Unknown Customer has been delivered.', 0, '2025-05-02 13:58:49'),
(65, 34, 'Order #36 for Unknown Customer has been delivered.', 0, '2025-05-02 14:36:09'),
(66, 38, 'Order #36 for Unknown Customer has been delivered.', 0, '2025-05-02 14:36:09'),
(67, 34, 'Order #37 for Unknown Customer has been delivered.', 0, '2025-05-02 15:03:11'),
(68, 38, 'Order #37 for Unknown Customer has been delivered.', 0, '2025-05-02 15:03:11'),
(69, 34, 'Order #38 for Unknown Customer has been delivered.', 0, '2025-05-09 17:12:20'),
(70, 38, 'Order #38 for Unknown Customer has been delivered.', 0, '2025-05-09 17:12:20'),
(71, 34, 'Order #48 for Unknown Customer has been delivered.', 0, '2025-05-10 22:32:24'),
(72, 38, 'Order #48 for Unknown Customer has been delivered.', 0, '2025-05-10 22:32:24'),
(73, 34, 'Order #64 for Unknown Customer has been delivered.', 0, '2025-05-11 21:10:32'),
(74, 38, 'Order #64 for Unknown Customer has been delivered.', 0, '2025-05-11 21:10:32'),
(75, 34, 'Order #70 for Unknown Customer has been delivered.', 0, '2025-05-11 23:23:28'),
(76, 38, 'Order #70 for Unknown Customer has been delivered.', 0, '2025-05-11 23:23:28'),
(77, 34, 'Order #71 for Unknown Customer has been delivered.', 0, '2025-05-12 00:12:43'),
(78, 38, 'Order #71 for Unknown Customer has been delivered.', 0, '2025-05-12 00:12:43'),
(79, 34, 'Order #72 for Unknown Customer has been delivered.', 0, '2025-05-12 00:12:44'),
(80, 38, 'Order #72 for Unknown Customer has been delivered.', 0, '2025-05-12 00:12:44'),
(81, 34, 'Order #73 for Unknown Customer has been delivered.', 0, '2025-05-12 13:05:00'),
(82, 38, 'Order #73 for Unknown Customer has been delivered.', 0, '2025-05-12 13:05:00'),
(83, 34, 'Order #74 for Unknown Customer has been delivered.', 0, '2025-05-12 15:07:21'),
(84, 38, 'Order #74 for Unknown Customer has been delivered.', 0, '2025-05-12 15:07:21'),
(85, 34, 'Order #75 for Unknown Customer has been delivered.', 0, '2025-05-12 15:07:22'),
(86, 38, 'Order #75 for Unknown Customer has been delivered.', 0, '2025-05-12 15:07:22'),
(87, 34, 'Order #76 for Unknown Customer has been delivered.', 0, '2025-05-12 15:07:22'),
(88, 38, 'Order #76 for Unknown Customer has been delivered.', 0, '2025-05-12 15:07:22'),
(89, 34, 'Order #77 for Unknown Customer has been delivered.', 0, '2025-05-12 15:20:34'),
(90, 38, 'Order #77 for Unknown Customer has been delivered.', 0, '2025-05-12 15:20:34'),
(91, 34, 'Order #78 for Unknown Customer has been delivered.', 0, '2025-05-12 15:30:01'),
(92, 38, 'Order #78 for Unknown Customer has been delivered.', 0, '2025-05-12 15:30:01'),
(93, 34, 'Order #79 for Unknown Customer has been delivered.', 0, '2025-05-12 16:16:42'),
(94, 38, 'Order #79 for Unknown Customer has been delivered.', 0, '2025-05-12 16:16:42'),
(95, 34, 'Order #80 for Unknown Customer has been delivered.', 0, '2025-05-12 16:19:34'),
(96, 38, 'Order #80 for Unknown Customer has been delivered.', 0, '2025-05-12 16:19:34'),
(97, 34, 'Order #81 for Unknown Customer has been delivered.', 0, '2025-05-12 20:17:40'),
(98, 38, 'Order #81 for Unknown Customer has been delivered.', 0, '2025-05-12 20:17:40'),
(99, 34, 'Order #82 for Unknown Customer has been delivered.', 0, '2025-05-12 21:16:53'),
(100, 38, 'Order #82 for Unknown Customer has been delivered.', 0, '2025-05-12 21:16:53'),
(101, 34, 'A new order has been placed by customer ID: 117 on 2025-05-12.', 0, '2025-05-12 21:56:07'),
(102, 38, 'A new order has been placed by customer ID: 117 on 2025-05-12.', 0, '2025-05-12 21:56:07'),
(103, 34, 'A new order has been placed by customer ID:  on 2025-05-12.', 0, '2025-05-12 21:56:11'),
(104, 38, 'A new order has been placed by customer ID:  on 2025-05-12.', 0, '2025-05-12 21:56:11'),
(105, 34, 'A new order has been placed by customer ID: 117 on 2025-05-12.', 0, '2025-05-12 22:23:16'),
(106, 38, 'A new order has been placed by customer ID: 117 on 2025-05-12.', 0, '2025-05-12 22:23:16'),
(107, 34, 'A new order has been placed by customer ID: 117 on 2025-05-12.', 0, '2025-05-12 23:24:58'),
(108, 38, 'A new order has been placed by customer ID: 117 on 2025-05-12.', 0, '2025-05-12 23:24:58'),
(109, 34, 'Order #99 for Unknown Customer has been delivered.', 0, '2025-05-13 00:18:57'),
(110, 38, 'Order #99 for Unknown Customer has been delivered.', 0, '2025-05-13 00:18:57'),
(111, 34, 'Order #98 for Unknown Customer has been delivered.', 0, '2025-05-13 00:19:03'),
(112, 38, 'Order #98 for Unknown Customer has been delivered.', 0, '2025-05-13 00:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `delivery_status` varchar(50) DEFAULT 'Pending',
  `rider_id` int(11) DEFAULT 0,
  `user_address` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `item_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `item_id`, `user_id`, `order_quantity`, `order_date`, `order_status`, `delivery_status`, `rider_id`, `user_address`, `phone_number`, `item_image`) VALUES
(98, 129, 118, 1, '2025-05-12', '1', 'Delivered', 37, 'Brgy. Balud P3, Cajurao St., Calbayog City', '09795504992', 'Cetaphil Baby Lotion 50ml.webp'),
(99, 156, 118, 1, '2025-05-12', '1', 'Delivered', 37, 'Brgy. Balud P3, Cajurao St., Calbayog City', '09795504992', 'Green Cross Total Defense Sanitizer pump 300ml.webp');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `user_fname` varchar(100) DEFAULT NULL,
  `user_lname` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `order_id`, `user_id`, `rating`, `comment`, `user_fname`, `user_lname`, `created_at`) VALUES
(16, 98, 118, 5, 'goods po yung product', 'Almer', 'Alontaga', '2025-05-12 16:19:42'),
(17, 99, 118, 5, 'same din po', 'Almer', 'Alontaga', '2025-05-12 16:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `rider_reviews`
--

CREATE TABLE `rider_reviews` (
  `review_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rider_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(100) NOT NULL,
  `user_lname` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rider_reviews`
--

INSERT INTO `rider_reviews` (`review_id`, `order_id`, `rider_id`, `rating`, `comment`, `user_id`, `user_fname`, `user_lname`, `created_at`) VALUES
(29, 98, 37, 5, 'Thank you po rider', 118, 'Almer', 'Alontaga', '2025-05-12 16:19:56'),
(30, 99, 37, 5, 'salamt rider', 118, 'Almer', 'Alontaga', '2025-05-12 16:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_lname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_id` int(3) NOT NULL,
  `user_fname` varchar(20) NOT NULL,
  `user_address` text NOT NULL,
  `secque` varchar(100) DEFAULT NULL,
  `secans` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_lname`, `email`, `user_password`, `phone_number`, `user_id`, `user_fname`, `user_address`, `secque`, `secans`, `profile_pic`) VALUES
('probadora', 'karen@gmail.com', '$2y$10$KtUnQxp01Maw.z4LOOnJ8OORlGes3tlCIWXMMKzyrdSdqnRPPHJuS', '09834959331', 117, 'karen clair', 'P-10 Brgy. Marcatubig Calbayog City Samar', 'What is your favourite color?', 'pink', 'profile_681609de93d1c0.64585815.jpg'),
('Alontaga', 'almer@gmail.com', '$2y$10$jRuwSkpM7i4Vk4Z3vpENk.iFMwZl7Eiy.fmOXnjvN4tEnQAS6/r8u', '09795504992', 118, 'Almer', 'Brgy. Balud P3, Cajurao St., Calbayog City', 'What is your favourite color?', 'blue', 'profile_681edc69271f89.38984109.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `profile_pic` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`profile_pic`, `id`, `fname`, `lname`, `email`, `password`, `role_id`) VALUES
('jacky.jpg', 34, 'jackylyn', 'enero', 'jackylyn@gmail.com', '$2y$10$85mCM1yn9ccnDGqYxXGwZe/ssaPC.as/4qZV8sntmR4AHFCGaD6VW', 2),
('almer.jpg', 37, 'almer', 'alontaga', 'almer@gmail.com', '$2y$10$LUKDR8TOzPJt8puw5Yg2.etQlLVrK8GsMX793NotOrMmk/3zWwWpy', 3),
('gelen.jpg', 38, 'gelen', 'capillo', 'gelencapillo@gmail.com', '$2y$10$eghDbCHCy4rc0iidU.H26.ES7hbvQhd7G9vV.x9I8B1LJExOnOoNW', 2),
('balane.jpg', 39, 'johnpaul', 'balane', 'johnpaul@gmail.com', '$2y$10$LzTGBCq.8IX.89OxU6m.LuSit.oSu4V705NHDhjMg7IGHPo2C4ZbO', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rider_reviews`
--
ALTER TABLE `rider_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rider_reviews`
--
ALTER TABLE `rider_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
