insert into dim_localidade (dsc_localidade)
select distinct
Location
from stg_indicadores_globais sig;

insert into dim_grupo_idade (dsc_grupo_idade)
select distinct
Age_Group
from stg_indicadores_globais sig;

insert into dim_indicador (seq_dim_meta, nom_indicador, dsc_frequencia, dsc_undiade)
select (select seq_dim_meta
from dim_meta dm
where dm.num_meta = sig.Target) as seq_dim_meta,
substring(trim(substring(sig.Series_Description, 3)), 3) as nom_indicador,
sig.Frequency,
sig.Unit
from stg_indicadores_globais sig
group by sig.Target,
sig.Series_Description,
sig.Frequency,
sig.Unit;

//CARGA DOS VALORES DOS INDICADORES
insert into dim_valor_indicador(seq_dim_indicador, seq_dim_tempo, seq_dim_tipo_dado, seq_dim_localidade, seq_dim_grupo_idade, ind_genero, vlr_indicador, dsc_fonte)
select (select group_concat(di.seq_dim_indicador)
from dim_indicador di,
dim_meta dm
where di.seq_dim_meta = dm.seq_dim_meta
and dm.num_meta = sig.Target
and di.nom_indicador = substring(trim(substring(sig.Series_Description, 3)), 3)),
(select dt.seq_dim_tempo from dim_tempo dt where dt.num_ano = 1986 and dt.num_mes = 1 and dt.num_dia = 1),
null,
(select dl.seq_dim_localidade from dim_localidade dl where dl.dsc_localidade = sig.Location),
(select dgi.seq_dim_grupo_idade from dim_grupo_idade dgi where dgi.dsc_grupo_idade = sig.Age_Group),
sig.Sex,
sig.1986,
sig.FN_1986
from stg_indicadores_globais sig;
