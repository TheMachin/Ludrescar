
<?php 
	/**
	* Paramètre d'entrée une variable de type tableau
	* Le nom des colonnes sont les clés de la variable
	**/
	function tableau($tab)
	{ 
?>
            <div class='container-fluid'>
                    <label>Nombre de lignes : <?php echo count($tab); ?></label>
                    <table id='tableID' class="table table-bordered table-striped">
                        <?php
                        $entete=FALSE;
                        $i=1;
                        foreach($tab as $row){
                            echo "";
                            if(!$entete){
                                    echo "<thead><tr><th width='20%'>#</th><th width='20%'>".implode("</th><th width='20%'>",array_keys($row))."</th></tr></thead><tbody>";
                                    $entete=TRUE;
                            }else{
                                    $i++;
                            }
                            echo "<tr><td width='20%'>".$i."</td><td width='20%'>".implode("</td><td width='20%'>",$row)."</td></tr>";
                            echo "";
                        }
                        echo "</tbody>";
                        ?>
                    </table>
            </div>
<?php
	}
?>