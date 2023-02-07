<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafico GANTT</title>

    <style>
        #boxGraficoGantt{
            background-color: rgb(55, 99, 132);
            padding: 70px;
            color: white;
            font-family: sans-serif;
           
        }

        #graficoPizza{
            width: 350px !important;
            height: 350px !important;
            background-color: #fff;
            padding: 20px;
            border-radius: 30px;
            
            display: inline;

        }

        #graficoGantt{
            width: 800px !important;
            height: 350px !important;
            background-color: #fff;
            padding: 20px;
            border-radius: 30px;
            margin-left: 50px !important;
            display: inline;

        }

        #hora{
            width: 250px !important;
            height: 250px !important;
            background-color: #fff;
            padding: 20px;
            border-radius: 30px;
            justify-content: center;
            display: flex;
            align-items: center;
        }

        .display{
            width: 150px !important;
            height: 150px !important;
            border-radius: 300px;
            background-color: #fff;
            padding: 20px;
            color: #fff;
            font-weight: bold;
            font-family: sans-serif;
            background-color: rgb(55, 99, 132);
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .porcentagem{
            width: 100px !important;
            height: 100px !important;
            border-radius: 300px;
            background-color: rgb(55, 99, 132);
            padding: 20px;
            display: inline;
            margin-left: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }



        #porcentagens{
            width: 800px !important;
            height: 250px !important;
            background-color: #fff;
            border-radius: 30px;
            margin-left: 100px !important;
            display: flex;
            align-content:space-between;
            align-items: center;
            justify-content: center;
            
            overflow-x: scroll;
        }


        .row{
            display: flex;
            align-content:space-between;
            margin-top: 50px !important;
        }

    </style>


</head>
<body>
    <?php

        //conexao com a base de dados
        $usuario = 'graneleiro';
        $senha = '12345';
        $host = 'localhost';
        $banco_dados = 'portos';

        $mysqli = new mysqli($host, $usuario, $senha, $banco_dados);

        // Check connection
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }

?>       
          
    <!--GRAFICO-->
    <div id="boxGraficoGantt" >
    
        <h1>DASHBOARD</h1>
        <div class="row">
            <canvas id="graficoPizza"></canvas>                
            <canvas id="graficoGantt"></canvas>
     
     
        </div>

        <?php
            $sql = "SELECT SEC_TO_TIME(SUM(t_fim) - SUM(t_inicio)) AS TOTAL FROM rota;";
            $hora = $mysqli->query($sql);

            if($hora == false){
                
                exit();
            }
        ?>

   

        <div class="row">
           
            <div id="hora">
                <h1 class="display"> <span id=""> <?php echo $hora->fetch_assoc()['TOTAL']; ?>  </span> </h1>
            </div>     
            
          
            <?php
                $sql = "SELECT * FROM `operacao` ";
                $produtos = $mysqli->query($sql);

               
            ?>

            <div id="porcentagens">
                <?php foreach ( $produtos->fetch_all()  as $produto) :?>
                    <div class="porcentagem">
                    <h5> <?= $produto[3] ?> </h5> &nbsp; <?= $produto[6] ?> % </div>
                <?php endforeach; ?>
            </div>  
            
            
        </div>



    </div>
   
    <!--JAVASCRIPT-->
    <script src="./js/chart.js"></script>
    <script src="./js/moment.js"></script>
    <script src="./js/chartjs-adapter-moment.js"></script>


<script>
    //constante que acrescenta o fuso horario brasileiro
    const acrescimoTempoFusoHorario = 3;

    //funcao que calcula os millisegundos de uma string no formato HH:mm:ss
    function stringParaMillisegundos(string) {
        let dados = string.split(":");
        let horas = Number(dados[0]) + acrescimoTempoFusoHorario;
        let minutos = Number(dados[1]);
        let segundos = Number(dados[2]);
        let total_segundos = (horas * 60 * 60) + (minutos * 60) + segundos;
        return (total_segundos * 1000);
    }

    let tarefas = [];
    let tempos_iniciais = [];
    let tempos_finais = [];

    <?php
        $sql = "SELECT id_rota, descricao, t_inicio, t_fim FROM rota";
        $resultado = $mysqli->query($sql);
        while ($linha = $resultado->fetch_assoc()) {
            echo 'tarefas.push("'. $linha['descricao'] . '");';
            echo 'tempos_iniciais.push(stringParaMillisegundos("' . $linha['t_inicio'] . '"));';
            echo 'tempos_finais.push(stringParaMillisegundos("' . $linha['t_fim'] . '"));';
        }
        $resultado -> free_result();            
    ?>

        console.log(tempos_iniciais);
        console.log(tempos_finais);


        let dados = [];
        for (let i = 0; i < tarefas.length; i++)
            dados.push([tempos_iniciais[i], tempos_finais[i]]);
        
        let dados_para_grafico = [{
            label: 'Tarefas',
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 159, 64, 0.8)',
            ],
            data: dados
        }];
        
        let configuracoes = {
            type: 'bar',
            options: {
                indexAxis: 'y',
                barPercentage: 0.60,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'hour',
                            displayFormats: {
                                hour: 'HH:mm'
                            }
                        },
                        min: moment(0) + moment(acrescimoTempoFusoHorario * 60 * 60 * 1000),
                        max: moment(86400000) + moment(acrescimoTempoFusoHorario * 60 * 60 * 1000)
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = 'Intervalo: ';

                                if (context.parsed.x !== null) {
                                    label += moment(context.raw[0]).format('HH:mm:ss');
                                    label += ' - ';
                                    label += moment(context.raw[1]).format('HH:mm:ss');
                                }

                                return label;
                            }
                        }
                    }
                },
            },
            data: {
                labels: tarefas,
                datasets: dados_para_grafico
            },
        };

        const meuGrafico = new Chart(
            document.getElementById("graficoGantt"),
            configuracoes
        );








    let pesos = [];
    let descricao = [];


    <?php
        //realiza a consulta
        $sql = "SELECT descricao, peso FROM tipo_carga";
        $resultado = $mysqli->query($sql);
        while ($linha = $resultado->fetch_assoc()) {
            echo 'pesos.push("'. $linha['peso'] . '");';
            echo 'descricao.push("'. $linha['descricao'] . '");';
       
        }

            $resultado -> free_result();
            $mysqli -> close();
    ?>

  


// Cria-se um objeto chamado dados onde:
let data = {
    datasets: [{
        // cria-se um vetor data, com os valores a ser dispostos no gráfico
        data: pesos,
        // cria-se uma propriedade para adicionar cores aos respectivos valores do vetor data
        backgroundColor: ['rgb(255, 99, 132)', 'rgb(255, 199, 132)', 'rgb(55, 99, 132)']
    }],

    // cria-se legendas para os respectivos valores do vetor data
    labels: descricao
};

// Crie um objeto que defina as opções customizáveis
// do seu gráfico.
let opcoes = {
    cutoutPercentage: 40,
};

var ctx = document.getElementById("graficoPizza").getContext("2d");

let meuDonutChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: opcoes
});


function zero(x) {
    if (x < 10) {
        x = '0' + x;
    } return x;
}

setInterval(function(){
    
    let novaHora = new Date();
    // getHours trará a hora
    // geMinutes trará os minutos
    // getSeconds trará os segundos
    let hora = novaHora.getHours();
    let minuto = novaHora.getMinutes();
    let segundo = novaHora.getSeconds();
    // Chamamos a função zero para que ela retorne a concatenação
    // com os minutos e segundos
    minuto = zero(minuto);
    segundo = zero(segundo);
    // Com o textContent, iremos inserir as horas, minutos e segundos
    // no nosso elemento HTML
    document.getElementById('display_hora').textContent = hora+':'+minuto+':'+segundo;
},1000)
</script>


</body>
</html>