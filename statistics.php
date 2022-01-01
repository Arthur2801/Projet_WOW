<!DOCTYPE html>
<?php session_start(); ?>
<html>

    <head>

        <meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="styles\style1.css"type="text/css" media="screen" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript"src="script.js"></script>

        <title>WoW Arena</title>

        <?php

            include ("bd.php");
            $bdd = getBD();

            //retourne le nombre de victoire global
            function win($nbj){
                $bdd = getBD();
                $wins="select count(victory) as win from import WHERE victory=1 and isRated=1 and playersNumber=$nbj and idUser=".$_SESSION['utilisateur'][1];
                $rep=$bdd->query($wins);
                $ligne = $rep ->fetch();
                return $ligne['win']." <span class='wins'>Wins</span> ";
            }
           
           //retourne le nombre de défaite global
           function lose($nbj){
                $bdd = getBD();
                $loses="select count(victory) as loses from import WHERE isRated=1 and victory=0 and playersNumber=$nbj and idUser=".$_SESSION['utilisateur'][1];
                $rep=$bdd->query($loses);
                $ligne = $rep ->fetch();
                return $ligne['loses']." <span class='loses'>Loses</span> ";
           }

           //retourne le % de victoire global
           function winrate($nbj){
                $bdd = getBD();
                $winrate="select count(victory)/(select count(victory) from import WHERE isRated=1 and playersNumber=$nbj and idUser=".$_SESSION['utilisateur'][1].")*100 as winrate from import WHERE victory=1 and isRated=1 and playersNumber=$nbj and idUser=".$_SESSION['utilisateur'][1];
                $rep=$bdd->query($winrate);
                $ligne = $rep ->fetch();
                return "<p>WinRate : ".round($ligne['winrate'],2)."%</p>";
           }

           //retourne le % de victoire en fonction de la spécialisation
            function winrS($spe,$nbj){
                $bdd = getBD();
                $sql2="select count(victory)/(select count(victory) from import WHERE isRated=1 and playersNumber=$nbj and specialization=".$spe."and idUser=".$_SESSION['utilisateur'][1].")*100 as winrS from import WHERE victory=1 and isRated=1 and playersNumber=$nbj and specialization=".$spe."and idUser=".$_SESSION['utilisateur'][1];
                $rep2=$bdd->query($sql2);
                $ligne2 = $rep2 ->fetch();
                return $ligne2['winrS'];
            }

            //retourne le nombre de victoire en fonction de la spécialisation
            function ws($spe,$nbj){
                $bdd = getBD();
                $wins="select count(victory) as win from import WHERE victory=1 and isRated=1 and playersNumber=$nbj and specialization=".$spe."and idUser=".$_SESSION['utilisateur'][1];
                $rep3=$bdd->query($wins);
                $ligne3 = $rep3 ->fetch();
                return $ligne3['win'];
            }

            //retourne le nombre de défaite en fonction de la spécialisation
            function ls($spe,$nbj){
                $bdd = getBD();
                $wins="select count(victory) as lose from import WHERE victory=0 and isRated=1 and playersNumber=$nbj and specialization=".$spe."and idUser=".$_SESSION['utilisateur'][1];
                $rep4=$bdd->query($wins);
                $ligne4 = $rep4 ->fetch();
                return $ligne4['lose'];
            }

            //retourne une image en fonction de la spécialisation
            function imgs($spe){
                $img="";
                if ($spe=="Beast Mastery") {
                    $spe="BeastMastery";
                    $img="<img class='imgs'src='images/".$spe.".png'/>";
                }else{
                    $img="<img class='imgs'src='images/".$spe.".png'/>";
                }
                return $img;
            }

            //affiche les matchups ayant un winrate<50% en fonction de la spécialisation 
            function matchup($class,$spe,$nbj){
                $bdd = getBD();
                $nb=0;
                $idu=$_SESSION['utilisateur'][1];
                echo "<ul class='mu'>";
                for($i=0;$i<count($class);$i++){
                    $spe2=$class[$i];
                    $nbp="select count(victory) as nbg from import WHERE isRated=1 and playersNumber=$nbj and ennemyComp LIKE '%$spe2%'and idUser=$idu and specialization='$spe'";
                    $repx=$bdd->query($nbp);
                    $lignex = $repx ->fetch();
                    if($lignex['nbg']>10){ 
                        $c1="select count(victory)/(select count(victory) from import WHERE isRated=1 and playersNumber=$nbj and ennemyComp LIKE '%$spe2%'and idUser=$idu and specialization='$spe')*100 as winrate from import WHERE victory=1 and isRated=1 and playersNumber=$nbj and ennemyComp LIKE '%$spe2%' and idUser=$idu and specialization='$spe'";
                        $rep6=$bdd->query($c1);
                        $ligne6 = $rep6 ->fetch();
                        if($ligne6['winrate']<=50){
                            $nb+=1;
                            echo "<li class='limg img".$spe2."'>".imgs($spe2)."</li>";
                            echo "<div class=' contdivspe'><li class='cont ".$spe2." part1'>Winrate against ".$spe2." : ".round($ligne6['winrate'],2)."%</li>";
                            echo "<li class='cont ".$spe2." part2'>".tips($spe2)."</li></div>";
                        }
                        
                    }
                    
                }
                if($nb==0){
                    echo "<li>No Matchup under 50% winrate found !</li>";
                }
                echo "</ul>";
            }

            //retourne des conseils en fonction des matchups
            function tips($spe){
                if($spe=="Unholy"){
                    return "<div><ul>
                                <li>• Try to kite the Death Knight because he has almost no movement CD.</li>
                                <li>• Watch out for his grab and covenant ability that makes him grab 5 times in 10 seconds, try to hide behind a pillar.</li>
                                <li>• Death Knight has a lot of HP and Defense so it's almost always a better idea to focus the other DPS.</li>
                            </ul></div>";
                }
                if($spe=="Havoc"){
                    return "<div><ul>
                                <li>• Havoc has a lot of burst potential with the ability <a href='https://www.wowhead.com/spell=323639/the-hunt'target='_blank'>The Hunt</a> that causes you to lose almost 50% of your hp instantly, be careful when you are low on life.</li>
                                <li>• Havoc lacks of defensive CD through the arena, so you might focus him until he dies.</li>
                                <li>• Havoc has a lot of mobility so kiting him might be a bad idea, you should try to focus him instead.</li>
                            </ul></div>";
                }
                if($spe=="Feral"){
                    return "<div><ul>
                                <li>• Feral has a lot of damage burst potential, especially with his covenant abilty 'Convoke the spirit' that has 2 minutes cooldown, try to kick it as soon as he casts it.</li>
                                <li>• Feral is very tanky when he is in his Bear Form but he does very little damage in this form.</li>
                                <li>• You can stun the feral to burst him down so he can't use his Bear Form to mitigate the damages.</li>
                            </ul></div>";
                }
                if($spe=="Balance"){
                    return "<div><ul>
                                <li>• Balance has a lot of damage burst potential, especially with his covenant abilty <a href='https://www.wowhead.com/spell=323764/convoke-the-spirits'target='_blank'>Convoke the spirit</a> that has 2 minutes cooldown, try to kick it as soon as he casts it.</li>
                                <li>• Balance is very tanky when he is in his Bear Form but he does very little damage in this form.</li>
                                <li>• You can stun the balance to burst him down so he can't use his Bear Form to mitigate the damages.</li>
                            </ul></div>";
                }
                if($spe=="BeastMastery"){
                    return "<div><ul>
                                <li>• Beast Mastery has a very useful ability that makes an ally immune to crits.</li>
                                <li>• You can mitigate a lot of the damage from the beast mastery if you CC his pets.</li>
                                <li>• Beast Mastery lacks of defensives CD so you can easly kill him, especially on a good stun.</li>
                            </ul></div>";
                }
                if($spe=="Survival"){
                    return "<div><ul>
                                <li>• Survival has a lot of burst potential, be careful when he use his freezing trap on another ally.</li>
                                <li>• Don't try to kite a Survival, he has always a lot of tools to keep harassing you even if he is a melee specialization.</li>
                                <li>• Survival lacks of defensives CD so you can easly kill him, especially on a good stun.</li>
                            </ul></div>";
                }
                if($spe=="Marksmanship"){
                    return "<div><ul>
                                <li>• Be careful for his strong covenant abilty that allows him to shoot you through walls, it can be very deadly.</li>
                                <li>• Marksmanship works a lot on big burst potential, especially at opening, so take care of each other.</li>
                                <li>• Marksmanship lacks of defensives CD so you can easly kill him, especially on a good stun.</li>
                            </ul></div>";
                }
                if($spe=="Fire"){
                    return "<div><ul>
                                <li>• Fire Mage has the biggest burst potential in the game with his spell 'Combustion', if he uses it, you should try to purge it, or to CC the mage and pop any Defensive CD you have.</li>
                                <li>• Fire Mage can reduce his combustion CD for 3 seconds everytime he casts a fireball, so be careful to not let him cast it too much.</li>
                                <li>• Mages have a very powerful defensive CD every 1 min that allows him to get back to his current HP after 10 seconds, but you can purge it !.</li>
                            </ul></div>";
                }
                if($spe=="Arcane"){
                    return "<div><ul>
                                <li>• Arcane Mage has a lot of burst potential at the opening, be careful to not get oneshoot !.</li>
                                <li>• Arcane Mage have every of his spell on the Arcane School of Magic, so if you kick any of his spell, he will be fully locked for the duration of the kick.</li>
                                <li>• Mages have a very powerful defensive CD every 1 min that allows him to get back to his current HP after 10 seconds, but you can purge it !.</li>
                            </ul></div>";
                }
                if($spe=="Frost"){
                    return "<div><ul>
                                <li>• Frost Mage has the less burst potential of the three specialization, but it deals good damage all the time.</li>
                                <li>• Frost Mage can be very annoying with all the slow and freeze they do, so you might focus them to avoid that.</li>
                                <li>• Mages have a very powerful defensive CD every 1 min that allows him to get back to his current HP after 10 seconds, but you can purge it !.</li>
                            </ul></div>";
                }
                if($spe=="Windwalker"){
                    return "<div><ul>
                                <li>• Windwalker has an insane burst potential, especially when he summons his tiger and his clones, so when he does you MUST use a defensive CD.</li>
                                <li>• His tiger and clones can be CCed so try to do that to mitigate a lot of damage.</li>
                                <li>• Windwalker has only one strong defensive CD every 1 min 30 that is touch of karma, but he can be easely taken down without it.</li>
                            </ul></div>";
                }
                if($spe=="Retribution"){
                    return "<div><ul>
                                <li>• Retribution has an insane burst potential everytime he gets his <a href='https://www.wowhead.com/spell=31884/avenging-wrath' target='_blank'>Wings</a> you have to kite it or tu use any defensive CD to try to survive it.</li>
                                <li>• Retribution has a lot of healing potential but to do so he has to lose a lot of burst so focusing him is a good idea.</li>
                                <li>• Retribution has only one big defensive CD that is his bubble, so after he used it, he is an easy focus.</li>
                            </ul></div>";
                }
                if($spe=="Shadow"){
                    return "<div><ul>
                                <li>• Shadow Priest has a lot of damage over time and burst potential but can be kicked to avoid damages for some times.</li>
                                <li>• Shadow Priest has a strong ability that allows him to swap his current hp with another ally. You can kill him instead if he does that to save his ally..</li>
                                <li>• Shadow Priest has some usefull defensives CD so it might not be the easiest class to focus.</li>
                            </ul></div>";
                }
                if($spe=="Assassination"){
                    return "<div><ul>
                                <li>• Assassination has a lot of damage over time with his poisons and dots, you should try avoid being at his melee range for too long.</li>
                                <li>• Rogues will always try to get out of combat behind a pillar to get a re-stealth so you should always try to keep them in combat.</li>
                                <li>• Rogues have only 2 defensives CD (one physical one magical) so you can easely kill them, especially on a good stun.</li>
                            </ul></div>";
                }
                if($spe=="Subtlety"){
                    return "<div><ul>
                                <li>• Subtlety has a lot of burst everytime he opens from stealth, so you should be careful when he is engaging on you.</li>
                                <li>• Rogues will always try to get out of combat behind a pillar to get a re-stealth so you should always try to keep them in combat.</li>
                                <li>• Rogues have only 2 defensives CD (one physical one magical) so you can easely kill them, especially on a good stun.</li>
                            </ul></div>";
                }
                if($spe=="Elemental"){
                    return "<div><ul>
                                <li>• Elemental has a big burst potential with his spell <a href='https://www.wowhead.com/spell=191634/stormkeeper' target='_blank'>Stormkeeper</a> so you should try to kick it when he casts it, or to use a defensive CD.</li>
                                <li>• Elemental has low healing potential so you should not really worry about his heals.</li>
                                <li>• Shamans have only one defensive CD every 1min30 so that makes them an easy target.</li>
                            </ul></div>";
                }
                if($spe=="Enhancement"){
                    return "<div><ul>
                                <li>• Enhancement has an insane burst potential that should be mitigated by a strong defensive CD.</li>
                                <li>• Enhancement has a lot of self healing potential so try to stun him if you are focusing him.</li>
                                <li>• Shamans have only one defensive CD every 1min30 so that makes them an easy target.</li>
                            </ul></div>";
                }
                if($spe=="Affliction"){
                    return "<div><ul>
                                <li>• Affliction has a lot of damage overtime and you should try to line them behind pillars to not get too much damage.</li>
                                <li>• Affliction has a big offensive CD 'Dark Soul' that can be purged or stealed.</li>
                                <li>• Warlocks have little mobility and bad defensives CD so they should be a priority target.</li>
                            </ul></div>";
                }
                if($spe=="Destruction"){
                    return "<div><ul>
                                <li>• Destruction has big burst potential with his chaos bolts so you should try to kick it or to make sure he doesn't land more than one on you.</li>
                                <li>• Destruction has a big offensive CD 'Dark Soul' that can be purged or stealed.</li>
                                <li>• Warlocks have little mobility and bad defensives CD so they should be a priority target.</li>
                            </ul></div>";
                }
                if($spe=="Arms"){
                    return "<div><ul>
                                <li>• Arms has a lot of sustained damages and applies a permanent -25% healing on his main target, so you should try to kite them as much as you can.</li>
                                <li>• Arms do a lot of damage when you're bellow 35% hp with his execution spell, you should try to always be above 35%hp to avoid his execution phase.</li>
                                <li>• Arms has only one big defensive CD that reduces the damage he takes for 30% and parry every physical attacks every 2 min.</li>
                            </ul></div>";
                }
            }
            
        ?>

		<style type="text/css">

			#v2 { 
				display: none;
			}

			#v3 {
                display: none;
                width: 700px;
                margin:auto;
            }
            #v2 {
                display: none;
                width: 700px;
                margin:auto;
            }
            .cont{
                padding: 10px;
                text-align: center;
            }
            .cont li{
                padding: 5px;
            }
            .limg{
                
                margin:5px;
            }
            .mu{
                padding-left: 0;
            }
            
            ul{
                list-style-type: none;
            }
            
            .spe{
                display: none;
                border-bottom:1px black;
                border-bottom:thick double;
            }

            .graph{
                width: 200px;
            }
            .cont>div>ul{
                padding-left: 0;
            }

            .part1{
                font-weight: bold;
                color: #212F3C;
            }
            
            .contdivspe{
                display: none;
            }
            .imgs{
                display: table-cell;
                margin:auto;
                cursor: pointer;
            }
            .specia>.imgs{
                margin:20px auto;

            }
            button{
                cursor: pointer;
            }
            input{
                cursor: pointer;
            }
            #v3>h2+div{
                border-bottom:1px black;
                border-bottom:thick double;

            }
            #v2>h2+div{
                border-bottom:1px black;
                border-bottom:thick double;

            }
            h3+.imgs{
                border-bottom:1px black;
                border-bottom:thick double; 
            }
            h3{
                text-decoration: underline black;
            }
            .wins{
                color:#007230;
            }
            .loses{
                color:#AD0000;
            }

		</style>

    </head>

    <body>
		
        <!-- Bandeau -->
		<div id="header">
			<a href="index.php"><img id="logo" src=images/logoW.png alt="WoW Arena"></a>
			<h1 class="title">WoW Arena</h1>
            <div id="text">

        <h3 class="bouton">
        <?php if(isset($_SESSION['utilisateur'])){
            echo "Welcome ". $_SESSION['utilisateur'][0];?> </h3>
            <h2 class="b"> •<a href="deconnexion.php" class="bouton">Log Out</a>
            •<a href="import.php" class="bouton">Import</a>
            •<a href="statistics.php" class="bouton">Statistics</a></h2>
        <?php }else{?>
            <h2 class="b"> •<a href="inscription.php" class="bouton">Sign Up</a>
            •<a href="connexion.php" class="bouton">Log In</a> </h2>
            <?php } ?>
        
        </div>
		</div>
		
		<div id="global">
		
        <button  onclick=v2()>2v2</button>
        <button  onclick=v3()>3v3</button>
		
		
        <?php

        $class=array("Unholy","Havoc","Feral","Balance","BeastMastery","Survival","Marksmanship","Fire","Arcane","Frost","Windwalker","Retribution","Shadow","Assassination","Subtlety","Elemental","Enhancement","Affliction","Destruction","Arms");

        //Partie 3v3
        echo "<div id='v3'><h2>3v3</h2>";
        $nbj=6; // nombre de joueur dans l'arène
        echo "<div><p>".win($nbj).lose($nbj)."</p>";
        echo winrate($nbj);
        echo "<img class='graph'src='graphs/graphPiev3.php'/></div>";
        echo "<div class='specia'><h3>Specialization</h3>";
        //Retourne les spécialisations du joueur en 3v3
        $spe="select DISTINCT specialization from import where idUser=".$_SESSION['utilisateur'][1]." and isRated=1 and playersNumber=6";
        $rep = $bdd->query($spe);
        while ($ligne = $rep ->fetch()) {
            $spe="'".$ligne['specialization']."'";
            $spe2=$ligne['specialization'];
            $nbj=6;
            $img="";
            if ($spe=="Beast Mastery") {
                $spe="BeastMastery";
                echo"<img class='imgs im".$spe2."'src='images/".$spe2.".png'/>";
            }else{
                echo"<img class='imgs im".$spe2."'src='images/".$spe2.".png'/>";
            }
            echo "<div class='spe div".$spe2."'><p>".ws($spe,$nbj)."<span class='wins'> Wins</span> / ".ls($spe,$nbj)." <span class='loses'>Loses</span></p>"."<p>Winrate: ".round(winrS($spe,$nbj),2)."% </p>";
            echo "<h3>Toughest Matchups</h3>";
            echo matchup($class,$spe2,$nbj)."</div>";
        }$rep ->closeCursor();
        echo"</div></div>";

        //Partie 2v2
        echo "<div id='v2'><h2>2v2</h2>";
        $nbj=4; // nombre de joueur dans l'arène
        echo "<div><p>".win($nbj).lose($nbj)."</p>";
        echo winrate($nbj);
        echo "<img class='graph'src='graphs/graphPiev2.php'/></div>";
        echo "<div class='specia'><h3>Specialization</h3>";
        //Retourne les spécialisations du joueur en 2v2
        $spe="select DISTINCT specialization from import where idUser=".$_SESSION['utilisateur'][1]." and isRated=1 and playersNumber=4";
        $rep = $bdd->query($spe);
        while ($ligne = $rep ->fetch()) {
            $spe="'".$ligne['specialization']."'";
            $spe2=$ligne['specialization'];
            $nbj=4;
            $img="";
            if ($spe=="Beast Mastery") {
                $spe="BeastMastery";
                echo"<img class='imgs im".$spe2."'src='images/".$spe2.".png'/>";
            }else{
                echo"<img class='imgs im".$spe2."'src='images/".$spe2.".png'/>";
            }
            echo "<div class='spe div".$spe2."'><p>".ws($spe,$nbj)." <span class='wins'>Wins</span> / ".ls($spe,$nbj)." <span class='loses'>Loses</span></p>"."<p>Winrate: ".round(winrS($spe,$nbj),2)."% </p>";
            echo"<h3>Toughest Matchups</h3>";
            echo matchup($class,$spe2,$nbj)."</div>";
        }$rep ->closeCursor();
        echo"</div></div>";
        ?>
		
        <p> <a href="delete.php"> <input type="button" value="Reset"> </a> </p>

		
		</div>
    </body>

</html>