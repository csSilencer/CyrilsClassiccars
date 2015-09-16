INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'FORD');
INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'MERCEDES-BENZ');
INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'DATSUN');
INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'HOLDEN');
INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'MINI');
INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'BMW');
INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'PLYMOUTH');
INSERT INTO MAKE VALUES (SEQ_MAKE_ID.NEXTVAL, 'CHEVROLET');

INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '1', 'MUSTANG');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '2', '300 SL');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '2', '300 SLR');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '3', 'FAIRLADY Z');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '4', 'TORANA LJ');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '4', 'VL CALAIS BT-1');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '5', 'COOPER MARK II');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '6', '3.0CSL');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '7', 'BARRACUDA');
INSERT INTO CMODEL VALUES (SEQ_MODEL_ID.NEXTVAL, '8', 'CORVETTE C3');

INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'CONVERTIBLE HARDTOP');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'CONVERTIBLE SOFTTOP');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'CHOP TOP');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'GULLWING DOORS');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'AIR CONDITIONING');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'TURBO INTERCOOLED');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'SUPERCHARGED INTERCOOLED');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'LIMITED SLIP DIFFERENTIAL');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'HEAVY DUTY CLUTCH');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'CHROME TRIM');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'CHROME WHEELS');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'CENTRAL LOCKING');
INSERT INTO FEATURE VALUES (SEQ_FEATURE_ID.NEXTVAL, 'ENGINE IMMOBILISER AND ALARM');

INSERT INTO CAR_FEATURE VALUES (SEQ_CAR_FEATURE_ID.NEXTVAL, '1', '5', '');
INSERT INTO CAR_FEATURE VALUES (SEQ_CAR_FEATURE_ID.NEXTVAL, '2', '7', '');
INSERT INTO CAR_FEATURE VALUES (SEQ_CAR_FEATURE_ID.NEXTVAL, '4', '', '');
INSERT INTO CAR_FEATURE VALUES (SEQ_CAR_FEATURE_ID.NEXTVAL, '6', '8', '9');
INSERT INTO CAR_FEATURE VALUES (SEQ_CAR_FEATURE_ID.NEXTVAL, '8', '9', '');
INSERT INTO CAR_FEATURE VALUES (SEQ_CAR_FEATURE_ID.NEXTVAL, '10', '11', '');
INSERT INTO CAR_FEATURE VALUES (SEQ_CAR_FEATURE_ID.NEXTVAL, '5', '12', '13');

INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '1', '1', 'REG001', 'COUPE', 'MANUAL', '68000', '1965', 'LIGHT BLUE', '2', '5', '4', '4.9', 'UNLEADED 91', 'REAR WHEEL DRIVE', '1');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '2', '2', 'REG002', 'COUPE', 'MANUAL', '30000', '1954', 'WHITE', '2', '4', '6', '3.0', 'UNLEADED 98', 'REAR WHEEL DRIVE', '3');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '2', '3', 'MERC01', 'COUPE', 'MANUAL', '80000', '1955', 'SILVER', '2', '1', '8', '3.0', 'LOW-LEAD GAS', 'REAR WHEEL DRIVE', '5');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '3', '4', 'D47SUN', 'COUPE', 'MANUAL', '45000', '1969', 'RED', '2', '2', '6', '2.0', 'UNLEADED 98', 'REAR WHEEL DRIVE', '4');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '4', '5', 'ULEGAL', 'SEDAN', 'MANUAL', '100000', '1972', 'ORANGE', '4', '5', '8', '5.0', 'UNLEADED 98', 'REAR WHEEL DRIVE', '6');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '4', '6', 'BT-1', 'SEDAN', 'MANUAL', '120000', '1988', 'CANARY YELLOW', '4', '5', '6', '3.0', 'UNLEADED 98', 'REAR WHEEL DRIVE', '4');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '5', '7', 'SMIL3Y', 'COUPE', 'MANUAL', '46500', '1967', 'DARK GREEN', '2', '4', '4', '0.8', 'UNLEADED 91', 'FRONT WHEEL DRIVE', '7');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '6', '8', 'REG003', 'COUPE', 'MANUAL', '27000', '1972', 'WHITE', '2', '5', '6', '3.2', 'UNLEADED 98', 'REAR WHEEL DRIVE', '');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '7', '9', 'SN4K3', 'COUPE', 'MANUAL', '250000', '1970', 'LIME GREEN', '2', '5', '8', '7.0', 'UNLEADED 98', 'REAR WHEEL DRIVE', '4');
INSERT INTO CAR VALUES (SEQ_CAR_ID.NEXTVAL, '8', '10', 'CHEVY', 'COUPE', 'MANUAL', '90000', '1976', 'RED', '2', '2', '8', '5.7', 'UNLEADED 98', 'REAR WHEEL DRIVE', '2');

INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, 'JOHN', 'CITIZEN', '1 ABCD STREET, MELBOURNE VIC 3000', '98981212', '0412345678', 'JOHN@CITIZEN.COM');
INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, 'SAM', 'JOHNSON', '2 ABCD STREET, MELBOURNE VIC 3000', '98888888', '0444444444', 'SAM@JOHNSON.COM');
INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, 'DARTH', 'VADER', '100 DEATH STAR ROAD, DEATH STAR', '66666666', '0466666666', 'DARTH@VADER.COM');
INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, 'GARY', 'GLITTER', '4 GLITTER BOULEVARD, SYDNEY NSW 2000', '8988446633', '0413465544', 'GARY@GLITTER.COM');
INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, 'KANYE', 'WEST', '9 KANYEBEST ROAD, BRISBANE QLD 4000', '76547654', '0423235652', 'KANYE@WEST.COM');
INSERT INTO CLIENT VALUES (SEQ_CLIENT_ID.NEXTVAL, 'MARK', 'ZUCKERBERG', '44 FACEBOOK STREET, MELBOURNE 3000', '98124563', '0450985545', 'MARK@ZUCKERBERG.COM');

INSERT INTO LISTING VALUES (SEQ_LISTING_ID.NEXTVAL, '1', '1', '38000');
INSERT INTO LISTING VALUES (SEQ_LISTING_ID.NEXTVAL, '4', '3', '56000');
INSERT INTO LISTING VALUES (SEQ_LISTING_ID.NEXTVAL, '2', '7', '48000');
INSERT INTO LISTING VALUES (SEQ_LISTING_ID.NEXTVAL, '6', '8', '90000');
INSERT INTO LISTING VALUES (SEQ_LISTING_ID.NEXTVAL, '6', '9', '33000');
INSERT INTO LISTING VALUES (SEQ_LISTING_ID.NEXTVAL, '6', '10', '74500');

INSERT INTO SALE VALUES (SEQ_SALE_ID.NEXTVAL, '1', '1', '36000');
INSERT INTO SALE VALUES (SEQ_SALE_ID.NEXTVAL, '4', '2', '50000');

COMMIT;