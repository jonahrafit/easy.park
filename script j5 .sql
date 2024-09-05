create view view_solde as 
select c.id, c.nom , c.prenom ,coalesce(tt.recharge,0 ) as recharge ,coalesce(tt.payement ,0 ) as payement
, coalesce(tt.recharge,0 ) - coalesce(tt.payement ,0 )as solde   from compte c
left join (
	select c.id , 
	(select coalesce(sum(p.montant) , 0) from portefeuille p 
     	where p.idcompte = c.id 
     		and p.idcompte not in (select idcompte from admin)
     		and p.isvalider ='OUI') as recharge,
	(select coalesce(sum(pa.montant) ,0) from payement pa 
     	where pa.idcompte = c.id) as payement 
	from compte c 
) as tt on tt.id = c.id ;



DELIMITER $$$
CREATE PROCEDURE eval_easy_park.view_etat_place(IN daty datetime)
BEGIN
select p.id as idplacee , tt.* , v.immatriculation ,
    timediff(tt.deadline , daty) as rebours, 
    HOUR(timediff(tt.deadline , daty)) as heure_rebours, 
    MINUTE(timediff(tt.deadline , daty)) as minute_rebours, 
    case when (timediff(tt.deadline , daty) < 0 ) then '100000' end as amende, 
    case 
        when (tt.idplace is not null and (timediff(tt.deadline , daty) >= 0 ) ) then 'OCCUPE' 
	    when (tt.idplace is not null and  (timediff(tt.deadline , daty) < 0 ) )  then 'INFRACT'
        when (select statut from place where id = p.id) = 'KO' then 'INDISP'
	    else 'LIBRE' end as statut 
from 
(
SELECT pv.id as idplace_voiture, pv.idplace  ,pv.idvoiture , pv.datetimedebut , pv.cout , pv.heure_tarif , pv.minute_tarif,
    case 
        when (TIME(pv.datetimedebut) >= time('6:00:00') and TIME(pv.datetimedebut) < time('8:00:00')) then (pv.cout - (pv.cout * 15 /100))
        when (TIME(pv.datetimedebut) >= time('12:00:00') and TIME(pv.datetimedebut) < time('14:00:00')) then (pv.cout + (pv.cout * 10 /100))
        when (TIME(pv.datetimedebut) >= time('18:00:00') and TIME(pv.datetimedebut) <= time('23:59:00')) 
            or (TIME(pv.datetimedebut) >= time('00:00:00') and TIME(pv.datetimedebut) < time('6:00:00')) 
            then 
            (  select tar.cout from tarif tar 
                where time_to_sec(time(concat(tar.heure,':',tar.minute,':00'))) >= abs(time_to_sec(timediff(time(concat(pv.heure_tarif,':',pv.minute_tarif,':00')) ,'01:00:00')))
                order by time(concat(tar.heure,':',tar.minute,':00')) limit 1 )
        else pv.cout
        end as cout_final,
    case 
        when (TIME(pv.datetimedebut) >= time('6:00:00') and TIME(pv.datetimedebut) < time('8:00:00')) then '15'
        end as remise,
    case 
        when (TIME(pv.datetimedebut) >= time('18:00:00') and TIME(pv.datetimedebut) <= time('23:59:00')) 
            or (TIME(pv.datetimedebut) >= time('00:00:00') and TIME(pv.datetimedebut) < time('6:00:00')) 
            then addtime(addtime(pv.datetimedebut, concat(pv.heure_tarif,':',pv.minute_tarif,':',00)) , time('1:00:00'))
        else addtime(pv.datetimedebut, concat(pv.heure_tarif,':',pv.minute_tarif,':',00)) 
        end as deadline
    FROM place_voiture pv WHERE (datetimedebut <= daty and datetimesortie >= daty) 
    OR (datetimedebut <= daty and datetimesortie IS NULL)
) as tt join voiture v on tt.idvoiture = v.id
    right join place p on tt.idplace = p.id ;
END $$$
DELIMITER ;


create view stat_de_parking as 
SELECT pv.id as idplace_voiture, pv.idplace  ,pv.idvoiture , pv.datetimedebut , pv.cout , pv.heure_tarif , pv.minute_tarif, pv.datetimesortie ,
    case 
        when (TIME(pv.datetimedebut) >= time('6:00:00') and TIME(pv.datetimedebut) < time('8:00:00')) then (pv.cout - (pv.cout * 15 /100))
        when (TIME(pv.datetimedebut) >= time('12:00:00') and TIME(pv.datetimedebut) < time('14:00:00')) then (pv.cout + (pv.cout * 10 /100))
         when (TIME(pv.datetimedebut) >= time('18:00:00') and TIME(pv.datetimedebut) <= time('23:59:00')) 
            or (TIME(pv.datetimedebut) >= time('00:00:00') and TIME(pv.datetimedebut) < time('6:00:00')) 
            then 
            (  select tar.cout from tarif tar 
                where time_to_sec(time(concat(tar.heure,':',tar.minute,':00'))) >= abs(time_to_sec(timediff(time(concat(pv.heure_tarif,':',pv.minute_tarif,':00')) ,'01:00:00')))
                order by time(concat(tar.heure,':',tar.minute,':00')) limit 1 )
        else pv.cout
        end as cout_final,
    case 
        when (TIME(pv.datetimedebut) >= time('6:00:00') and TIME(pv.datetimedebut) < time('8:00:00')) then '15'
        end as remise,
    case 
        when (TIME(pv.datetimedebut) >= time('18:00:00') and TIME(pv.datetimedebut) <= time('23:59:00')) 
            or (TIME(pv.datetimedebut) >= time('00:00:00') and TIME(pv.datetimedebut) < time('6:00:00')) 
            then addtime(addtime(pv.datetimedebut, concat(pv.heure_tarif,':',pv.minute_tarif,':',00)) , time('1:00:00'))
        else addtime(pv.datetimedebut, concat(pv.heure_tarif,':',pv.minute_tarif,':',00)) 
        end as deadline
    FROM place_voiture pv order by idplace_voiture desc;



DELIMITER $$$
CREATE PROCEDURE eval_easy_park.view_situation_praking(IN daty datetime)
BEGIN
select tt.* , v.immatriculation , case when (timediff(tt.deadline , daty) < 0 ) then '100000' end as amende 
from stat_de_parking as tt 
	join voiture v on tt.idvoiture = v.id
    where (datetimesortie is null) or (datetimesortie > date_sub(daty,interval 1 day));
END $$$
DELIMITER ;