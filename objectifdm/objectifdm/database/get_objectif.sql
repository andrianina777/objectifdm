CREATE OR REPLACE FUNCTION objectifdm.get_objectif(xannee character, xmois character, dm character varying)
 RETURNS TABLE(id bigint, articles character varying, libelles text, labos character varying, qteder bigint, evolution numeric, objectif bigint, venteqte bigint, taux numeric, actif boolean, coms text)
 LANGUAGE plpgsql
AS $function$
	declare t_mois integer;
begin
	select mois_num into t_mois from postgres.objectifdm.mois  where trim(mois)=trim(xmois);
	
	return query
		select cast(objseq as bigint), cast(obj_article as varchar(25)) ,libelle,cast(obj_labo as varchar(25))  as labos ,cast(objventeqteder as bigint)  as qteder,obj_multik as evolution,
		cast(objqteobj as bigint) as objectif,cast(qte as bigint) as VenteQte,cast(((cast(qte as bigint)*100.00/COALESCE(cast(objqteobj as bigint),1))::numeric(14,2)) as numeric(14,2))  as taux ,(case when obj_article is null then false else true end)
		,cast(COALESCE(objcommantaire,'') as text) as coms from
		postgres.objectifdm.fobject inner join postgres.objectifdm.view_article on trim(view_article.article)=trim(obj_article)
		left join postgres.equagestion.v_bel_mois_annee on trim(v_bel_mois_annee.article)=trim(obj_article) and annee=objannee and mois=objmois
		where objannee=cast(xannee as integer) and objmois=cast(t_mois as integer) and obj_prenom=dm
		order by obj_article,libelle;

end
$function$
