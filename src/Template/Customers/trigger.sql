/* CREATE ACCOUNTS */
DELIMITER $$

CREATE TRIGGER create_accounts
AFTER INSERT
ON customers FOR EACH ROW
BEGIN

    INSERT INTO accounts(customer_id, user_id, created, modified, rate_id, account_number, balance)
        VALUES(new.id, new.user_id, new.created, new.modified, 1, CONCAT('190221560', NEW.id), 0);

    INSERT INTO accounts(customer_id, user_id, created, modified, rate_id, account_number, balance)
        VALUES(new.id, new.user_id, new.created, new.modified, 2, CONCAT('160221560', NEW.id), 0);
    
END$$

DELIMITER ;

/* UPDATE ACCOUNT BALANCE */

DELIMITER $$

CREATE TRIGGER update_account_balance
AFTER INSERT
ON transactions FOR EACH ROW
BEGIN
	IF (new.type = 1) THEN
    	UPDATE accounts SET balance = (balance - new.amount) WHERE accounts.id = new.account_id;
    ELSE
       UPDATE accounts SET balance = (balance + new.amount) WHERE accounts.id = new.account_id;
    END IF;
    
END$$




/* UPDATE ACCOUNT BALANCE ON DELETE */

DELIMITER $$

CREATE TRIGGER update_account_balance_after_delete
AFTER DELETE
ON transactions FOR EACH ROW
BEGIN
	IF (old.type = 1) THEN
    	UPDATE accounts SET balance = (balance + old.amount) WHERE accounts.id = old.account_id;
    ELSE
       UPDATE accounts SET balance = (balance - old.amount) WHERE accounts.id = old.account_id;
    END IF;
    
END$$

DELIMITER ;


/* CASCADE DELETE FOR TRANSACTIONS */
DELIMITER $$

CREATE TRIGGER DELETE_CHILD_ROW 
BEFORE DELETE ON sales
FOR EACH ROW
BEGIN
    DELETE FROM transactions WHERE sale_id=old.id;
END$$

DELIMITER ;






