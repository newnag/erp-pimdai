-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 11, 2026 at 08:27 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u745958510_erppimdai`
--

-- --------------------------------------------------------

--
-- Table structure for table `AssetCategories`
--

CREATE TABLE `AssetCategories` (
  `category_code` varchar(50) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `depreciation_rate` decimal(5,2) DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Assets`
--

CREATE TABLE `Assets` (
  `id` int(11) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `asset_name` varchar(255) NOT NULL,
  `category_id` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `doc_ref` varchar(100) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT 1.00,
  `seller_name` varchar(255) DEFAULT NULL,
  `product_serial` varchar(100) DEFAULT NULL,
  `exp_warranty` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `depreciation_date` date DEFAULT NULL,
  `purchase_cost` decimal(15,2) DEFAULT 0.00,
  `salvage_value` decimal(15,2) DEFAULT 0.00,
  `depreciable_amount` decimal(15,2) DEFAULT 0.00,
  `useful_year` int(11) DEFAULT 0,
  `annual_depreciation_expense_percent` decimal(5,2) DEFAULT 0.00,
  `annual_depreciation_expense` decimal(15,2) DEFAULT 0.00,
  `status` enum('Active','Disposed','Sold') NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Attendance`
--

CREATE TABLE `Attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `work_hours` decimal(5,2) DEFAULT 0.00,
  `status` enum('Present','Late','Absent','Leave') NOT NULL DEFAULT 'Present',
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `BillingItems`
--

CREATE TABLE `BillingItems` (
  `id` int(11) NOT NULL,
  `billing_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Billings`
--

CREATE TABLE `Billings` (
  `billing_no` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `billing_date` date NOT NULL,
  `credit_term` int(11) DEFAULT 0,
  `billing_exp` date DEFAULT NULL,
  `no_ref` varchar(100) DEFAULT NULL,
  `type_price` enum('ราคาไม่รวมภาษี','ราคารวมภาษี') NOT NULL DEFAULT 'ราคาไม่รวมภาษี',
  `warehouse` int(11) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT 0.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `tax_amount` decimal(15,2) DEFAULT 0.00,
  `grand_total` decimal(15,2) DEFAULT 0.00,
  `withholding_tax` decimal(15,2) DEFAULT 0.00,
  `status` enum('Pending','Delivered','Invoiced') NOT NULL DEFAULT 'Pending',
  `remark` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `link_file` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Claims`
--

CREATE TABLE `Claims` (
  `id` int(11) NOT NULL,
  `claim_date` date NOT NULL,
  `inkjet_claim` int(11) DEFAULT 0,
  `digital_claim` int(11) DEFAULT 0,
  `accessory_claim` int(11) DEFAULT 0,
  `remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE `Customers` (
  `id` int(11) NOT NULL,
  `contact_type` enum('Individual','Corporate') NOT NULL DEFAULT 'Individual',
  `customer_type` enum('Customer','Vendor') NOT NULL DEFAULT 'Customer',
  `credit_limit` decimal(15,2) DEFAULT 0.00,
  `contact_id` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `tax_id` varchar(50) DEFAULT NULL,
  `com_branch` enum('Head','Branch') DEFAULT 'Head',
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `delivery_note` text DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_acc_no` varchar(50) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `link_file` varchar(500) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Depreciations`
--

CREATE TABLE `Depreciations` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `begin_year` date NOT NULL,
  `end_year` date NOT NULL,
  `asset_amount` int(11) DEFAULT 0,
  `total_asset_amount` decimal(15,2) DEFAULT 0.00,
  `depreciation` decimal(15,2) DEFAULT 0.00,
  `remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ExpenseCategories`
--

CREATE TABLE `ExpenseCategories` (
  `id` int(11) NOT NULL,
  `category_code` varchar(50) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Expenses`
--

CREATE TABLE `Expenses` (
  `expense_no` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `detail` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Paid') NOT NULL DEFAULT 'Pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ExtraDuties`
--

CREATE TABLE `ExtraDuties` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `duty_date` date NOT NULL,
  `duty_type` varchar(100) DEFAULT NULL,
  `recall` int(11) DEFAULT 0,
  `link_file` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `InvoiceItems`
--

CREATE TABLE `InvoiceItems` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Invoices`
--

CREATE TABLE `Invoices` (
  `invoice_no` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `credit_term` int(11) DEFAULT 0,
  `invoice_exp` date DEFAULT NULL,
  `no_ref` varchar(100) DEFAULT NULL,
  `type_price` enum('ราคาไม่รวมภาษี','ราคารวมภาษี') NOT NULL DEFAULT 'ราคาไม่รวมภาษี',
  `warehouse` int(11) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT 0.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `tax_amount` decimal(15,2) DEFAULT 0.00,
  `grand_total` decimal(15,2) DEFAULT 0.00,
  `withholding_tax` decimal(15,2) DEFAULT 0.00,
  `status` enum('Unpaid','Partial','Paid','Overdue') NOT NULL DEFAULT 'Unpaid',
  `remark` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `link_file` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Marketing_FB`
--

CREATE TABLE `Marketing_FB` (
  `id` int(11) NOT NULL,
  `campaing_date` date NOT NULL,
  `facebook_budget` decimal(15,2) DEFAULT 0.00,
  `facebook_inbox` int(11) DEFAULT 0,
  `facebook_remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Marketing_GG`
--

CREATE TABLE `Marketing_GG` (
  `id` int(11) NOT NULL,
  `campaing_date` date NOT NULL,
  `google_budget` decimal(15,2) DEFAULT 0.00,
  `google_click` int(11) DEFAULT 0,
  `google_remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Marketing_Line`
--

CREATE TABLE `Marketing_Line` (
  `id` int(11) NOT NULL,
  `campaing_date` date NOT NULL,
  `line_budget` decimal(15,2) DEFAULT 0.00,
  `line_follow` int(11) DEFAULT 0,
  `line_click` int(11) DEFAULT 0,
  `line_actual` int(11) DEFAULT 0,
  `line_remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Marketing_PF`
--

CREATE TABLE `Marketing_PF` (
  `id` int(11) NOT NULL,
  `campaing_date` date NOT NULL,
  `performance_Reach` varchar(255) DEFAULT NULL,
  `performance_remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Payments`
--

CREATE TABLE `Payments` (
  `payment_no` varchar(50) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` enum('Cash','Transfer','Cheque','Credit') NOT NULL DEFAULT 'Transfer',
  `reference_no` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProductCategories`
--

CREATE TABLE `ProductCategories` (
  `id` int(11) NOT NULL,
  `category_code` varchar(50) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `id` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_type` enum('Service','Finished Goods','Raw Materials') NOT NULL DEFAULT 'Finished Goods',
  `description` text DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `cost_price` decimal(15,2) DEFAULT 0.00,
  `selling_price` decimal(15,2) DEFAULT 0.00,
  `reorder_level` int(11) DEFAULT 0,
  `current_stock` int(11) DEFAULT 0,
  `product_img` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PurchaseOrderItems`
--

CREATE TABLE `PurchaseOrderItems` (
  `id` int(11) NOT NULL,
  `purchase_order_id` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PurchaseOrders`
--

CREATE TABLE `PurchaseOrders` (
  `po_no` varchar(50) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `expected_date` date DEFAULT NULL,
  `credit` int(11) DEFAULT 0,
  `status` enum('Draft','Sent','Confirmed','Received','Cancelled') NOT NULL DEFAULT 'Draft',
  `no_ref` varchar(100) DEFAULT NULL,
  `type_price` enum('ราคาไม่รวมภาษี','ราคารวมภาษี') NOT NULL DEFAULT 'ราคาไม่รวมภาษี',
  `warehouse` int(11) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT 0.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `tax_amount` decimal(15,2) DEFAULT 0.00,
  `grand_total` decimal(15,2) DEFAULT 0.00,
  `withholding_tax` decimal(15,2) DEFAULT 0.00,
  `remark` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `link_file` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `QuotationItems`
--

CREATE TABLE `QuotationItems` (
  `id` int(11) NOT NULL,
  `quotation_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Quotations`
--

CREATE TABLE `Quotations` (
  `quotation_no` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quotation_date` date NOT NULL,
  `credit_term` int(11) DEFAULT 0,
  `quotation_exp` date DEFAULT NULL,
  `no_ref` varchar(100) DEFAULT NULL,
  `type_price` enum('ราคาไม่รวมภาษี','ราคารวมภาษี') NOT NULL DEFAULT 'ราคาไม่รวมภาษี',
  `warehouse` int(11) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT 0.00,
  `discount_percent` decimal(5,2) DEFAULT 0.00,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `tax_amount` decimal(15,2) DEFAULT 0.00,
  `grand_total` decimal(15,2) DEFAULT 0.00,
  `withholding_tax` decimal(15,2) DEFAULT 0.00,
  `status` enum('Draft','Sent','Approved','Rejected','Converted') NOT NULL DEFAULT 'Draft',
  `remark` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `link_file` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StockInItems`
--

CREATE TABLE `StockInItems` (
  `id` int(11) NOT NULL,
  `stock_in_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_cost` decimal(15,2) NOT NULL,
  `total_cost` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StockIns`
--

CREATE TABLE `StockIns` (
  `stock_in_no` varchar(50) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `purchase_order_id` varchar(50) DEFAULT NULL,
  `received_date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StockItems`
--

CREATE TABLE `StockItems` (
  `id` int(11) NOT NULL,
  `stock_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `quantity_adj` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StockMovements`
--

CREATE TABLE `StockMovements` (
  `stock_no` varchar(50) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `movement_type` enum('IN','OUT','ADJUSTMENT') NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `movement_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StockOutItems`
--

CREATE TABLE `StockOutItems` (
  `id` int(11) NOT NULL,
  `stock_out_no` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `StockOuts`
--

CREATE TABLE `StockOuts` (
  `stock_out_no` varchar(50) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `billing_id` varchar(50) DEFAULT NULL,
  `issued_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `stock_out_type` enum('ส่งขายให้ลูกค้า','ใช้งานภายใน','ส่งซ่อม','อื่นๆ') NOT NULL DEFAULT 'ส่งขายให้ลูกค้า',
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Suppliers`
--

CREATE TABLE `Suppliers` (
  `id` int(11) NOT NULL,
  `contact_type` enum('Individual','Corporate') NOT NULL DEFAULT 'Corporate',
  `supplier_code` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `tax_id` varchar(50) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `business_add` enum('ไทย','ต่างประเทศ') DEFAULT 'ไทย',
  `payment_term_days` int(11) DEFAULT 0,
  `com_branch` enum('Head','Branch') DEFAULT 'Head',
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `product_type` int(11) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_acc_no` varchar(50) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `link_file` varchar(500) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SurveyCalls`
--

CREATE TABLE `SurveyCalls` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `survey_date` date NOT NULL,
  `survey_time` time DEFAULT NULL,
  `qt_no` varchar(50) DEFAULT NULL,
  `status_call` enum('รับสาย','ไม่รับสาย','เบอร์ผิด') NOT NULL,
  `feedback` enum('ปิดบิลใหม่','สนใจ/รอพิจารณา','ไม่สนใจ','เลื่อนการตัดสินใจ','ความคิดเห็นเชิงลบ') DEFAULT NULL,
  `follow_date` date DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('Admin','Sales','Inventory','Purchase','Accountant','Marketing') NOT NULL DEFAULT 'Sales',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Warehouses`
--

CREATE TABLE `Warehouses` (
  `id` int(11) NOT NULL,
  `warehouse_code` varchar(50) NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `WithholdingTaxes`
--

CREATE TABLE `WithholdingTaxes` (
  `id` int(11) NOT NULL,
  `wht_no` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `tax_id` varchar(50) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `tax_type` enum('Service','Rent','Professional') NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL,
  `tax_amount` decimal(15,2) NOT NULL,
  `remark` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AssetCategories`
--
ALTER TABLE `AssetCategories`
  ADD PRIMARY KEY (`category_code`);

--
-- Indexes for table `Assets`
--
ALTER TABLE `Assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_code` (`asset_code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_asset_code` (`asset_code`);

--
-- Indexes for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_attendance_date` (`attendance_date`),
  ADD KEY `idx_user_date` (`user_id`,`attendance_date`);

--
-- Indexes for table `BillingItems`
--
ALTER TABLE `BillingItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_no` (`billing_no`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Billings`
--
ALTER TABLE `Billings`
  ADD PRIMARY KEY (`billing_no`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `warehouse` (`warehouse`),
  ADD KEY `idx_billing_date` (`billing_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `Claims`
--
ALTER TABLE `Claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_claim_date` (`claim_date`);

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_customer_type` (`customer_type`),
  ADD KEY `idx_tax_id` (`tax_id`);

--
-- Indexes for table `Depreciations`
--
ALTER TABLE `Depreciations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `ExpenseCategories`
--
ALTER TABLE `ExpenseCategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_code` (`category_code`);

--
-- Indexes for table `Expenses`
--
ALTER TABLE `Expenses`
  ADD PRIMARY KEY (`expense_no`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_expense_date` (`expense_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `ExtraDuties`
--
ALTER TABLE `ExtraDuties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_duty_date` (`duty_date`);

--
-- Indexes for table `InvoiceItems`
--
ALTER TABLE `InvoiceItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Invoices`
--
ALTER TABLE `Invoices`
  ADD PRIMARY KEY (`invoice_no`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `warehouse` (`warehouse`),
  ADD KEY `idx_invoice_date` (`invoice_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `Marketing_FB`
--
ALTER TABLE `Marketing_FB`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_campaing_date` (`campaing_date`);

--
-- Indexes for table `Marketing_GG`
--
ALTER TABLE `Marketing_GG`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_campaing_date` (`campaing_date`);

--
-- Indexes for table `Marketing_Line`
--
ALTER TABLE `Marketing_Line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_campaing_date` (`campaing_date`);

--
-- Indexes for table `Marketing_PF`
--
ALTER TABLE `Marketing_PF`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_campaing_date` (`campaing_date`);

--
-- Indexes for table `Payments`
--
ALTER TABLE `Payments`
  ADD PRIMARY KEY (`payment_no`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `idx_payment_date` (`payment_date`);

--
-- Indexes for table `ProductCategories`
--
ALTER TABLE `ProductCategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_code` (`category_code`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD KEY `idx_product_code` (`product_code`),
  ADD KEY `idx_category_id` (`category_id`);

--
-- Indexes for table `PurchaseOrderItems`
--
ALTER TABLE `PurchaseOrderItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `PurchaseOrders`
--
ALTER TABLE `PurchaseOrders`
  ADD PRIMARY KEY (`po_no`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `warehouse` (`warehouse`),
  ADD KEY `idx_order_date` (`order_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `QuotationItems`
--
ALTER TABLE `QuotationItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_no` (`quotation_no`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Quotations`
--
ALTER TABLE `Quotations`
  ADD PRIMARY KEY (`quotation_no`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `warehouse` (`warehouse`),
  ADD KEY `idx_quotation_date` (`quotation_date`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `StockInItems`
--
ALTER TABLE `StockInItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_in_no` (`stock_in_no`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `StockIns`
--
ALTER TABLE `StockIns`
  ADD PRIMARY KEY (`stock_in_no`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `idx_received_date` (`received_date`);

--
-- Indexes for table `StockItems`
--
ALTER TABLE `StockItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_no` (`stock_no`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `StockMovements`
--
ALTER TABLE `StockMovements`
  ADD PRIMARY KEY (`stock_no`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `idx_movement_date` (`movement_date`),
  ADD KEY `idx_movement_type` (`movement_type`);

--
-- Indexes for table `StockOutItems`
--
ALTER TABLE `StockOutItems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_out_no` (`stock_out_no`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `StockOuts`
--
ALTER TABLE `StockOuts`
  ADD PRIMARY KEY (`stock_out_no`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `billing_id` (`billing_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_issued_date` (`issued_date`);

--
-- Indexes for table `Suppliers`
--
ALTER TABLE `Suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_code` (`supplier_code`),
  ADD KEY `idx_supplier_code` (`supplier_code`);

--
-- Indexes for table `SurveyCalls`
--
ALTER TABLE `SurveyCalls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_survey_date` (`survey_date`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- Indexes for table `Warehouses`
--
ALTER TABLE `Warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `warehouse_code` (`warehouse_code`);

--
-- Indexes for table `WithholdingTaxes`
--
ALTER TABLE `WithholdingTaxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wht_no` (`wht_no`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `idx_payment_date` (`payment_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Assets`
--
ALTER TABLE `Assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Attendance`
--
ALTER TABLE `Attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BillingItems`
--
ALTER TABLE `BillingItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Claims`
--
ALTER TABLE `Claims`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Customers`
--
ALTER TABLE `Customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Depreciations`
--
ALTER TABLE `Depreciations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ExpenseCategories`
--
ALTER TABLE `ExpenseCategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ExtraDuties`
--
ALTER TABLE `ExtraDuties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `InvoiceItems`
--
ALTER TABLE `InvoiceItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Marketing_FB`
--
ALTER TABLE `Marketing_FB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Marketing_GG`
--
ALTER TABLE `Marketing_GG`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Marketing_Line`
--
ALTER TABLE `Marketing_Line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Marketing_PF`
--
ALTER TABLE `Marketing_PF`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProductCategories`
--
ALTER TABLE `ProductCategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PurchaseOrderItems`
--
ALTER TABLE `PurchaseOrderItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `QuotationItems`
--
ALTER TABLE `QuotationItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `StockInItems`
--
ALTER TABLE `StockInItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `StockItems`
--
ALTER TABLE `StockItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `StockOutItems`
--
ALTER TABLE `StockOutItems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Suppliers`
--
ALTER TABLE `Suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SurveyCalls`
--
ALTER TABLE `SurveyCalls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Warehouses`
--
ALTER TABLE `Warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `WithholdingTaxes`
--
ALTER TABLE `WithholdingTaxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Assets`
--
ALTER TABLE `Assets`
  ADD CONSTRAINT `Assets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `AssetCategories` (`category_code`) ON DELETE SET NULL;

--
-- Constraints for table `Attendance`
--
ALTER TABLE `Attendance`
  ADD CONSTRAINT `Attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `BillingItems`
--
ALTER TABLE `BillingItems`
  ADD CONSTRAINT `BillingItems_ibfk_1` FOREIGN KEY (`billing_no`) REFERENCES `Billings` (`billing_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `BillingItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Billings`
--
ALTER TABLE `Billings`
  ADD CONSTRAINT `Billings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Billings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Billings_ibfk_3` FOREIGN KEY (`warehouse`) REFERENCES `Warehouses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `Depreciations`
--
ALTER TABLE `Depreciations`
  ADD CONSTRAINT `Depreciations_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `Assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Expenses`
--
ALTER TABLE `Expenses`
  ADD CONSTRAINT `Expenses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ExpenseCategories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Expenses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ExtraDuties`
--
ALTER TABLE `ExtraDuties`
  ADD CONSTRAINT `ExtraDuties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `InvoiceItems`
--
ALTER TABLE `InvoiceItems`
  ADD CONSTRAINT `InvoiceItems_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `Invoices` (`invoice_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `InvoiceItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Invoices`
--
ALTER TABLE `Invoices`
  ADD CONSTRAINT `Invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Invoices_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Invoices_ibfk_3` FOREIGN KEY (`warehouse`) REFERENCES `Warehouses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `Payments`
--
ALTER TABLE `Payments`
  ADD CONSTRAINT `Payments_ibfk_1` FOREIGN KEY (`invoice_no`) REFERENCES `Invoices` (`invoice_no`) ON DELETE CASCADE;

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `Products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ProductCategories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `PurchaseOrderItems`
--
ALTER TABLE `PurchaseOrderItems`
  ADD CONSTRAINT `PurchaseOrderItems_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `PurchaseOrders` (`po_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `PurchaseOrderItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `PurchaseOrders`
--
ALTER TABLE `PurchaseOrders`
  ADD CONSTRAINT `PurchaseOrders_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `Suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `PurchaseOrders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `PurchaseOrders_ibfk_3` FOREIGN KEY (`warehouse`) REFERENCES `Warehouses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `QuotationItems`
--
ALTER TABLE `QuotationItems`
  ADD CONSTRAINT `QuotationItems_ibfk_1` FOREIGN KEY (`quotation_no`) REFERENCES `Quotations` (`quotation_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `QuotationItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Quotations`
--
ALTER TABLE `Quotations`
  ADD CONSTRAINT `Quotations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Quotations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Quotations_ibfk_3` FOREIGN KEY (`warehouse`) REFERENCES `Warehouses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `StockInItems`
--
ALTER TABLE `StockInItems`
  ADD CONSTRAINT `StockInItems_ibfk_1` FOREIGN KEY (`stock_in_no`) REFERENCES `StockIns` (`stock_in_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `StockInItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `StockIns`
--
ALTER TABLE `StockIns`
  ADD CONSTRAINT `StockIns_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `Warehouses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `StockIns_ibfk_2` FOREIGN KEY (`purchase_order_id`) REFERENCES `PurchaseOrders` (`po_no`) ON DELETE SET NULL,
  ADD CONSTRAINT `StockIns_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `Suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `StockItems`
--
ALTER TABLE `StockItems`
  ADD CONSTRAINT `StockItems_ibfk_1` FOREIGN KEY (`stock_no`) REFERENCES `StockMovements` (`stock_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `StockItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `StockMovements`
--
ALTER TABLE `StockMovements`
  ADD CONSTRAINT `StockMovements_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `Warehouses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `StockOutItems`
--
ALTER TABLE `StockOutItems`
  ADD CONSTRAINT `StockOutItems_ibfk_1` FOREIGN KEY (`stock_out_no`) REFERENCES `StockOuts` (`stock_out_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `StockOutItems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `StockOuts`
--
ALTER TABLE `StockOuts`
  ADD CONSTRAINT `StockOuts_ibfk_1` FOREIGN KEY (`warehouse_id`) REFERENCES `Warehouses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `StockOuts_ibfk_2` FOREIGN KEY (`billing_id`) REFERENCES `Billings` (`billing_no`) ON DELETE SET NULL,
  ADD CONSTRAINT `StockOuts_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `SurveyCalls`
--
ALTER TABLE `SurveyCalls`
  ADD CONSTRAINT `SurveyCalls_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `SurveyCalls_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `WithholdingTaxes`
--
ALTER TABLE `WithholdingTaxes`
  ADD CONSTRAINT `WithholdingTaxes_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
