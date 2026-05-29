-- =============================================================
-- DUMMY DATA SEEDER — for review before execution
-- =============================================================
-- Purpose: Create food items + contracts + contract_items
--          for ALL prison institutions (IDs 9–35).
--
-- Existing data that may overlap:
--   items: IDs 1-11 exist, so new ones start at 13
--   contracts: IDs 1-13 exist, so new ones start at 14
--   contract_items: IDs 1-9 exist, new ones appended
-- =============================================================

-- 1. UOMs (if not exist)
INSERT IGNORE INTO uom (id, code, description) VALUES
(10, 'Kg',  'Kilogram'),
(11, 'Tin', 'Tin / Can');

-- 2. Food items for prison rations
INSERT IGNORE INTO items (id, category_id, subcategories_id, ceiling_limit_id, uom_id, name, price_per_unit, current_quantity, status, created_by, created_at, updated_by, updated_at) VALUES
(13, 1,1,1,10, 'Ikan Basah (Fresh Fish)',           8.50,  0,1,1,NOW(),1,NOW()),
(14, 1,1,1,10, 'Daging Lembu (Beef)',              18.00,  0,1,1,NOW(),1,NOW()),
(15, 1,1,1,10, 'Daging Ayam (Chicken)',            12.50,  0,1,1,NOW(),1,NOW()),
(16, 1,1,1,10, 'Sayur Daun (Leafy Vegetables)',     3.50,  0,1,1,NOW(),1,NOW()),
(17, 1,1,1,10, 'Kobis (Cabbage)',                   2.80,  0,1,1,NOW(),1,NOW()),
(18, 1,1,1,10, 'Bawang Merah (Onion)',              4.00,  0,1,1,NOW(),1,NOW()),
(19, 1,1,1,10, 'Bawang Putih (Garlic)',             6.00,  0,1,1,NOW(),1,NOW()),
(20, 1,1,1,10, 'Kentang (Potato)',                  3.00,  0,1,1,NOW(),1,NOW()),
(21, 1,1,1,10, 'Beras (Rice) 5kg',                 15.00,  0,1,1,NOW(),1,NOW()),
(22, 1,1,1,10, 'Minyak Masak (Cooking Oil) 5kg',   25.00,  0,1,1,NOW(),1,NOW()),
(23, 1,1,1,10, 'Gula (Sugar) 1kg',                  2.80,  0,1,1,NOW(),1,NOW()),
(24, 1,1,1,4,  'Telur (Eggs) per biji',             0.60,  0,1,1,NOW(),1,NOW()),
(25, 1,1,1,11, 'Sardin Tin (Sardines)',             3.50,  0,1,1,NOW(),1,NOW()),
(26, 1,1,1,10, 'Tepung Gandum (Wheat Flour) 1kg',   2.50,  0,1,1,NOW(),1,NOW()),
(27, 1,1,1,11, 'Susu Pekat Manis (Condensed Milk)', 4.50,  0,1,1,NOW(),1,NOW()),
(28, 1,1,1,10, 'Kacang Merah (Red Beans) 1kg',      5.50,  0,1,1,NOW(),1,NOW()),
(29, 1,1,1,10, 'Garam (Salt) 1kg',                  1.20,  0,1,1,NOW(),1,NOW()),
(30, 1,1,1,10, 'Cili Kering (Dried Chilli) 1kg',   12.00,  0,1,1,NOW(),1,NOW());

-- 3. Contracts for each prison institution (9–35), supplier cycles 1–5
INSERT IGNORE INTO contracts (id, contract_no, institution_id, supplier_id, start_date, end_date, total_value, status, created_by, created_at, updated_by, updated_at) VALUES
(14, 'KONTRAK/2026/006/P9',   9,  1, '2026-01-01','2026-12-31',125000,'Active',1,NOW(),1,NOW()),
(15, 'KONTRAK/2026/007/P10', 10,  2, '2026-01-01','2026-12-31', 95000,'Active',1,NOW(),1,NOW()),
(16, 'KONTRAK/2026/008/P11', 11,  3, '2026-01-01','2026-12-31',110000,'Active',1,NOW(),1,NOW()),
(17, 'KONTRAK/2026/009/P12', 12,  4, '2026-01-01','2026-12-31',100000,'Active',1,NOW(),1,NOW()),
(18, 'KONTRAK/2026/010/P13', 13,  5, '2026-01-01','2026-12-31',130000,'Active',1,NOW(),1,NOW()),
(19, 'KONTRAK/2026/011/P14', 14,  1, '2026-01-01','2026-12-31', 88000,'Active',1,NOW(),1,NOW()),
(20, 'KONTRAK/2026/012/P15', 15,  2, '2026-01-01','2026-12-31',140000,'Active',1,NOW(),1,NOW()),
(21, 'KONTRAK/2026/013/P16', 16,  3, '2026-01-01','2026-12-31',115000,'Active',1,NOW(),1,NOW()),
(22, 'KONTRAK/2026/014/P17', 17,  4, '2026-01-01','2026-12-31',105000,'Active',1,NOW(),1,NOW()),
(23, 'KONTRAK/2026/015/P18', 18,  5, '2026-01-01','2026-12-31', 98000,'Active',1,NOW(),1,NOW()),
(24, 'KONTRAK/2026/016/P19', 19,  1, '2026-01-01','2026-12-31',120000,'Active',1,NOW(),1,NOW()),
(25, 'KONTRAK/2026/017/P20', 20,  2, '2026-01-01','2026-12-31',160000,'Active',1,NOW(),1,NOW()),
(26, 'KONTRAK/2026/018/P21', 21,  3, '2026-01-01','2026-12-31',108000,'Active',1,NOW(),1,NOW()),
(27, 'KONTRAK/2026/019/P22', 22,  4, '2026-01-01','2026-12-31',145000,'Active',1,NOW(),1,NOW()),
(28, 'KONTRAK/2026/020/P23', 23,  5, '2026-01-01','2026-12-31', 75000,'Active',1,NOW(),1,NOW()),
(29, 'KONTRAK/2026/021/P24', 24,  1, '2026-01-01','2026-12-31',112000,'Active',1,NOW(),1,NOW()),
(30, 'KONTRAK/2026/022/P25', 25,  2, '2026-01-01','2026-12-31',118000,'Active',1,NOW(),1,NOW()),
(31, 'KONTRAK/2026/023/P26', 26,  3, '2026-01-01','2026-12-31', 70000,'Active',1,NOW(),1,NOW()),
(32, 'KONTRAK/2026/024/P27', 27,  4, '2026-01-01','2026-12-31',135000,'Active',1,NOW(),1,NOW()),
(33, 'KONTRAK/2026/025/P28', 28,  5, '2026-01-01','2026-12-31',125000,'Active',1,NOW(),1,NOW()),
(34, 'KONTRAK/2026/026/P29', 29,  1, '2026-01-01','2026-12-31',115000,'Active',1,NOW(),1,NOW()),
(35, 'KONTRAK/2026/027/P30', 30,  2, '2026-01-01','2026-12-31',102000,'Active',1,NOW(),1,NOW()),
(36, 'KONTRAK/2026/028/P31', 31,  3, '2026-01-01','2026-12-31',155000,'Active',1,NOW(),1,NOW()),
(37, 'KONTRAK/2026/029/P32', 32,  4, '2026-01-01','2026-12-31',128000,'Active',1,NOW(),1,NOW()),
(38, 'KONTRAK/2026/030/P33', 33,  5, '2026-01-01','2026-12-31', 90000,'Active',1,NOW(),1,NOW()),
(39, 'KONTRAK/2026/031/P34', 34,  1, '2026-01-01','2026-12-31',150000,'Active',1,NOW(),1,NOW()),
(40, 'KONTRAK/2026/032/P35', 35,  2, '2026-01-01','2026-12-31', 85000,'Active',1,NOW(),1,NOW());

-- 4. Contract_items — each new contract links to ALL 18 food items
--    Uses a cross join: every contract (id ≥ 14) × every food item (id ≥ 13)
--    unit_price pulled from items.price_per_unit
INSERT IGNORE INTO contract_items (contract_id, item_id, uom_id, estimated_quantity, unit_price, is_internally_supplied, notes, created_by, created_at)
SELECT c.id, i.id, i.uom_id, 100.00, i.price_per_unit, 0, 'Ration item', 1, NOW()
FROM contracts c
CROSS JOIN items i
WHERE c.id >= 14
  AND i.id BETWEEN 13 AND 30;
