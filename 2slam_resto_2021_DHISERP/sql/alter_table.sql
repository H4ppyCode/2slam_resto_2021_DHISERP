/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Pacôme
 * Created: Sep 27, 2021
 */

ALTER TABLE utilisateur
ADD mdpU_temp varchar(255);

UPDATE utilisateur SET mdpU_temp = mdpU;

ALTER TABLE utilisateur
DROP COLUMN mdpU,
ADD mdpU varchar(255);

UPDATE utilisateur SET mdpU = mdpU_temp;

ALTER TABLE utilisateur
DROP COLUMN mdpU_temp;

---

ALTER TABLE utilisateur ADD Admin boolean;
UPDATE utilisateur SET Admin = 1 WHERE mailU = "test@bts.sio";