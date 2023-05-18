<h1>Hello World !</h1>
<style>
    table{
        margin: flex;
        width: 500px;
        height: 500px;
        border:2px solid #02589F;
        text-align: center;
        border-collapse: collapse; 
    }
    
    td{
        padding: 5px;
        width: 10%;
        height: 10%;
        font-size: 2rem;
        border: 1px solid #0271C0;
        transition: all .4s;
    }
    td:nth-child(3),
    td:nth-child(6){
        border-right: 2px solid #02589F;
    }

    td:hover{
        background-color: rgba(100, 155, 219, 0.3);
        transition: all .2s;
        cursor: pointer;
    }

    td.true{
        background-color: rgba(72, 196, 1, 0.21);
    }

    td.false {
        background-color: rgba(255, 66, 66, 0.5);
    }
    
    tr{
        border: 1px solid #0271C0;
    }
    tr:nth-child(3),
        tr:nth-child(6)
        {
            border-bottom: 2px solid #02589F;
        }
</style>
<table>
    <?php foreach($sudoku as $lignes): ?>
        <tr>
            <?php foreach($lignes as $cases) : ?>
                <td><?= ($cases == 0) ? ' ' : $cases ?></td>
            <?php endforeach ?>
        </tr>
    <?php endforeach ?>
</table>