-- If vendor request status is approved, then insert its data to vendors
DELIMITER //
CREATE TRIGGER TRG_approve_vendors
AFTER UPDATE
   ON VENDOR_REQUEST FOR EACH ROW
BEGIN
  IF new.status = 'approved'
  THEN
  INSERT INTO VENDORS
  (email, password, first_name, last_name, company_name, phone_number, city, state, status)
  VALUES
  (new.email, new.password, new.first_name, new.last_name, new.company_name, new.phone_number, new.city, new.state, new.status);
  END IF;
END; //
DELIMITER ;


