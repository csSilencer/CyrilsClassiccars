CREATE TABLE CLIENT (
  CLIENT_ID NUMBER(7) NOT NULL,
  CLIENT_GIVENNAME VARCHAR2(50) NOT NULL,
  CLIENT_FAMILYNAME VARCHAR2(50) NOT NULL,
  CLIENT_ADDRESS VARCHAR2(200),
  CLIENT_PHONE VARCHAR2(12),
  CLIENT_MOBILE VARCHAR2(12),
  CLIENT_EMAIL VARCHAR2(50),
  CLIENT_MAILINGLIST VARCHAR2(1),
  CONSTRAINT CLIENT_PK PRIMARY KEY (CLIENT_ID)
);

CREATE TABLE SALE (
  SALE_ID NUMBER(7) NOT NULL,
  CLIENT_ID NUMBER(7) NOT NULL,
  LISTING_ID NUMBER(7) NOT NULL,
  SALE_COST NUMBER(20) NOT NULL,
  CONSTRAINT SALE_PK PRIMARY KEY (SALE_ID)
);

CREATE TABLE LISTING (
  LISTING_ID NUMBER(7) NOT NULL,
  CLIENT_ID NUMBER(7) NOT NULL,
  CAR_ID NUMBER(7) NOT NULL,
  LISTING_PRICE NUMBER(20) NOT NULL,
  CONSTRAINT LISTING_PK PRIMARY KEY (LISTING_ID)
);

CREATE TABLE CAR (
  CAR_ID NUMBER(7) NOT NULL,
  MAKE_ID NUMBER(7) NOT NULL,
  MODEL_ID NUMBER(7) NOT NULL,
  CAR_REG VARCHAR2(6) NOT NULL,
  CAR_BODYTYPE VARCHAR2(10) NOT NULL,
  CAR_TRANSMISSION VARCHAR2(10) NOT NULL,
  CAR_ODOMETER NUMBER(6) NOT NULL,
  CAR_YEAR NUMBER(4) NOT NULL,
  CAR_COLOUR VARCHAR2(20) NOT NULL,
  CAR_DOORS NUMBER(1) NOT NULL,
  CAR_SEATS NUMBER(1) NOT NULL,
  CAR_CYLINDERS NUMBER(2) NOT NULL,
  CAR_ENGINESIZE NUMBER(2) NOT NULL,
  CAR_FUELTYPE VARCHAR2(12) NOT NULL,
  CAR_DRIVETYPE VARCHAR2(30) NOT NULL,
  CAR_FEATURE_ID NUMBER(7),
  CAR_IMGDIR VARCHAR(50),
  CONSTRAINT CAR_PK PRIMARY KEY (CAR_ID)
);

CREATE TABLE MAKE (
  MAKE_ID NUMBER(7) NOT NULL,
  MAKE_NAME VARCHAR2(30) NOT NULL,
  CONSTRAINT MAKE_PK PRIMARY KEY (MAKE_ID)
);

CREATE TABLE CMODEL (
  MODEL_ID NUMBER(7) NOT NULL,
  MAKE_ID NUMBER(7) NOT NULL,
  MODEL_NAME VARCHAR2(30) NOT NULL,
  CONSTRAINT MODEL_PK PRIMARY KEY (MODEL_ID)
);

CREATE TABLE CAR_FEATURE (
  CAR_FEATURE_ID NUMBER(7) NOT NULL,
  FEATURE_ID_1 NUMBER(7),
  FEATURE_ID_2 NUMBER(7),
  FEATURE_ID_3 NUMBER(7),
  CONSTRAINT CAR_FEATURE_PK PRIMARY KEY (CAR_FEATURE_ID)
);

CREATE TABLE FEATURE (
  FEATURE_ID NUMBER(7) NOT NULL,
  FEATURE_NAME VARCHAR2(50) NOT NULL,
  CONSTRAINT FEATURE_PK PRIMARY KEY (FEATURE_ID)
);

ALTER TABLE SALE ADD CONSTRAINT SALE_CLIENT_FK FOREIGN KEY (CLIENT_ID) REFERENCES CLIENT (CLIENT_ID) ON DELETE CASCADE;
ALTER TABLE SALE ADD CONSTRAINT SALE_LISTING_FK FOREIGN KEY (LISTING_ID) REFERENCES LISTING (LISTING_ID) ON DELETE CASCADE;
ALTER TABLE LISTING ADD CONSTRAINT LISTING_CLIENT_FK FOREIGN KEY (CLIENT_ID) REFERENCES CLIENT (CLIENT_ID) ON DELETE CASCADE;
ALTER TABLE LISTING ADD CONSTRAINT LISTING_CAR_FK FOREIGN KEY (CAR_ID) REFERENCES CAR (CAR_ID) ON DELETE CASCADE;
ALTER TABLE CAR ADD CONSTRAINT CAR_MAKE_FK FOREIGN KEY (MAKE_ID) REFERENCES MAKE (MAKE_ID) ON DELETE CASCADE;
ALTER TABLE CAR ADD CONSTRAINT CAR_MODEL_FK FOREIGN KEY (MODEL_ID) REFERENCES CMODEL (MODEL_ID) ON DELETE CASCADE;
ALTER TABLE CAR ADD CONSTRAINT CAR_FEATURE_FK FOREIGN KEY (CAR_FEATURE_ID) REFERENCES CAR_FEATURE (CAR_FEATURE_ID) ON DELETE CASCADE;
ALTER TABLE CMODEL ADD CONSTRAINT MODEL_MAKE_FK FOREIGN KEY (MAKE_ID) REFERENCES MAKE (MAKE_ID) ON DELETE CASCADE;
ALTER TABLE CAR_FEATURE ADD CONSTRAINT CAR_FEATURE_ID_1_FK FOREIGN KEY (FEATURE_ID_1) REFERENCES FEATURE (FEATURE_ID) ON DELETE CASCADE;
ALTER TABLE CAR_FEATURE ADD CONSTRAINT CAR_FEATURE_ID_2_FK FOREIGN KEY (FEATURE_ID_2) REFERENCES FEATURE (FEATURE_ID) ON DELETE CASCADE;
ALTER TABLE CAR_FEATURE ADD CONSTRAINT CAR_FEATURE_ID_3_FK FOREIGN KEY (FEATURE_ID_3) REFERENCES FEATURE (FEATURE_ID) ON DELETE CASCADE;

CREATE SEQUENCE SEQ_CAR_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;
CREATE SEQUENCE SEQ_MAKE_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;
CREATE SEQUENCE SEQ_MODEL_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;
CREATE SEQUENCE SEQ_LISTING_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;
CREATE SEQUENCE SEQ_SALE_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;
CREATE SEQUENCE SEQ_FEATURE_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;
CREATE SEQUENCE SEQ_CAR_FEATURE_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;
CREATE SEQUENCE SEQ_CLIENT_ID START WITH 1 INCREMENT BY 1 MINVALUE 1 NOCACHE NOCYCLE;

COMMIT;