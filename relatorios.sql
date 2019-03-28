use barbeshop;

select 
c.cliente_id as 'ID Cliente', cl.nome, precofinal as 'Preço', c.data, c.status, b.nome as 'Nome Barbeiro'
from comanda c
inner join cliente cl on 
cl.id = c.cliente_id
inner join comanda_service co on
c.id = co.comanda_id
inner join barber b on 
co.barber_id = b.id
where c.data = '2018-09-09';



/** Quantidade de cortes do Barbeiro de uma determinada data**/ 
select count(service_id), b.nome
from comanda_service c
inner join barber b on
c.barber_id = b.id
inner join comanda co on
co.id = c.comanda_id
where co.data = '2018-09-09'
group by b.nome;

/** Quantidade em serviços do Barbeiro de uma determinada data**/ 
select count(service_id) as 'Quantiade de Cortes', b.nome, sum(s.preco) as 'R$', co.data, com.porcentagem  
from comanda_service c
inner join barber b on
c.barber_id = b.id
inner join comanda co on
co.id = c.comanda_id
left join service s on
s.id = c.service_id
inner join comissao com on
com.id = b.comissao_id
where co.data between '2018-10-01' and '2018-10-22' and b.id = 2
group by b.nome;


/** Selecao de comandas por barbeiros */
select b.nome, co.data, com.porcentagem, comanda_id, s.nome, s.preco 
from comanda_service c
inner join barber b on
c.barber_id = b.id
inner join comanda co on
co.id = c.comanda_id
left join service s on
s.id = c.service_id
inner join comissao com on
com.id = b.comissao_id
where co.data between '2018-09-01' and '2018-10-23' and b.id = 1;

