```
sudo mysqldump --no-create-info --compact --skip-triggers killteam Faction        > ktdash_seeding_01_Faction.sql
sudo mysqldump --no-create-info --compact --skip-triggers killteam Killteam       > ktdash_seeding_02_Killteam.sql     
sudo mysqldump --no-create-info --compact --skip-triggers killteam Fireteam       > ktdash_seeding_03_Fireteam.sql     
sudo mysqldump --no-create-info --compact --skip-triggers killteam Operative      > ktdash_seeding_04_Operative.sql    
sudo mysqldump --no-create-info --compact --skip-triggers killteam Ability        > ktdash_seeding_05_Ability.sql      
sudo mysqldump --no-create-info --compact --skip-triggers killteam UniqueAction   > ktdash_seeding_06_UniqueAction.sql 
sudo mysqldump --no-create-info --compact --skip-triggers killteam Weapon         > ktdash_seeding_07_Weapon.sql       
sudo mysqldump --no-create-info --compact --skip-triggers killteam WeaponProfile  > ktdash_seeding_08_WeaponProfile.sql
sudo mysqldump --no-create-info --compact --skip-triggers killteam Equipment      > ktdash_seeding_09_Equipment.sql    
sudo mysqldump --no-create-info --compact --skip-triggers killteam Ploy           > ktdash_seeding_10_Ploy.sql         
sudo mysqldump --no-create-info --compact --skip-triggers killteam TacOp          > ktdash_seeding_11_TacOp.sql        
sudo mysqldump --no-create-info --compact --skip-triggers killteam User             --where="userid IN ('vince', 'prebuilt', 'AYHNm', 'ElJ61')" > ktdash_seeding_12_User.sql
sudo mysqldump --no-create-info --compact --skip-triggers killteam Roster           --where="userid IN ('vince', 'prebuilt', 'AYHNm', 'ElJ61')" > ktdash_seeding_13_Roster.sql
sudo mysqldump --no-create-info --compact --skip-triggers killteam RosterOperative  --where="userid IN ('vince', 'prebuilt', 'AYHNm', 'ElJ61')" > ktdash_seeding_14_RosterOperative.sql
```
