<?php
//est une sous classe de Character
class Warrior extends Character
{
    //Attributs
    
    protected $_berserkPMax;
    protected $_berserkP;
    protected $_etatBerserk;

    public function __construct($name, $maxHealth, $armor, $berserkPMax)
    {
        parent::__construct($name, $maxHealth, $armor);
        $this->setEtatBerserk(0);
        $this->setberserkPMax($berserkPMax);
        $this->setberserkP(0);
    }
    //get

    public function getberserkPMax()
    {
        return $this->_berserkPMax;
    }
    public function getberserkP()
    {
        return $this->_berserkP;
    }
    public function getEtatBerserk()
    {
        return $this->_etatBerserk;
    }

    public function getEtatBerserkHUD()
    {
        if($this->_etatBerserk<=1)
        {
            return("<b style='color=#8BC34A;'>calme</b>");
        }
        elseif($this->_etatBerserk>1 && $this->_etatBerserk<3)
        {
            return("<b style='color=#FF9800;'>en colère</b>");
        }
        elseif($this->_etatBerserk>3 && $this->_etatBerserk<5)
        {
            return("<b style='color=#FF5722;'>en rage</b>");
        }
        elseif($this->_etatBerserk>=5)
        {
            return("<b style='color=#f44336;'>en mode <font size='1.2em' color='#c62828'>BERSERK</font></b>");
        }
        
    }
    public function getberserkPHUD()
    {
        return("<b style='color=#FFE082;'>".$this->_berserkP."</b>");
        
    }
    public function getberserkPMaxHUD()
    {
        return("<b style='color=#FFCC80;'>".$this->_berserkPMax."</b>");
    }

    //set
    public function setberserkPMax($val)
    {
        $this->_berserkPMax=$val;
    }
    public function setberserkP($val)
    {
        $this->_berserkP=$val;
        if($this->_berserkP > $this->_berserkPMax)
        {
            $this->_berserkP = $this->_berserkPMax;
        }
        if($this->_berserkP < 0)
        {
            $this->_berserkP=0;
        }
        if($this->_berserkP == 0 && $this->getEtatBerserk()>=5)
        {
            echo("<p style='color:#CFD8DC;'>".$this->getName()." sors du mode Berserk.</p>");
            $this->setEtatBerserk(0);
        }
        //Update du mode berserk
        if($this->_berserkP >0 && $this->_berserkP<=($this->_berserkPMax*20)/100 && $this->getEtatBerserk()<5)
        {
            $this->setEtatBerserk(0);
        }
        elseif($this->_berserkP >($this->_berserkPMax*20)/100 && $this->_berserkP<=($this->_berserkPMax*60)/100 && $this->getEtatBerserk()<5)
        {
            $this->setEtatBerserk(2);
        }
        elseif($this->_berserkP >($this->_berserkPMax*60)/100&& $this->_berserkP<($this->_berserkPMax*100)/100&& $this->getEtatBerserk()<5)
        {
            $this->setEtatBerserk(4);
        }
        elseif($this->_berserkP == $this->_berserkPMax && $this->getEtatBerserk()<5)
        {
            echo("<p style='color:#d32f2f;'>".$this->getName()." entre en mode Berserk.</p>");
            $this->setEtatBerserk(5);
        }
    }
    public function setEtatBerserk($val)
    {
        $this->_etatBerserk=$val;
    }

    //Méthodes
    public function getAll()
    {
        echo("<p>".$this->getNameHUD()." est un Guerrier ".$this->getEtatBerserkHUD().", il possède ".$this->getHealthHUD()."/".$this->getMaxHealthHUD()." PV, ".$this->getberserkPHUD()."/".$this->getberserkPMaxHUD()." points de Colère et ".$this->getArmorHUD()." points d'armure.");
    }

    public function updateBerserk($dmg, $getHit)
    {
        if($getHit == true)
        {
            if($this->getEtatBerserk()<5)
            {
                $this->setberserkP(round($this->getberserkP()+($dmg*25)/100));
            }
        }
        else
        {
            if($this->getEtatBerserk()>=5)
            {
                $this->setberserkP(round($this->getberserkP()-($dmg*50)/100));
            }
            else
            {
                $this->setberserkP(round($this->getberserkP()+($dmg*20)/100));
            }
            
        }
    }

    public function getHit($dmg)
    {
        if($dmg>0)
        {
            $dmg=round($dmg);
            //Le Guerrier ne contre pas, il n'esquive pas, mais il divise par deux ses dmg si il ignore les dégats en mode Berserk
            if($this->getEtatBerserk()>=5)
            {
                $this->updateBerserk($dmg,true);
                echo("<p style='color:#f44336;'>".$this->getName()." reçois une attaque, cela ne semble pas lui poser de problème. (".$dmg.")</p>");
                $dmg=0;
            }
            else
            {
                
                $dmg -= $this->getArmor();
                if($this->getEtatBerserk()>=5)
                {
                    $this->updateBerserk($dmg,false);
                }
                $this->setHealth($this->getHealth()-$dmg);
                echo("<p style='color:#e57373;'>".$this->getName()." se prend l'attaque de plein fouet et prend <b style='color:red;'>".$dmg."</b> points de dégats ! <b style='color:red;'>(PV:".$this->getHealth()."/".$this->getMaxHealth().")</b></p>");
            }
        }
    }
    public function hit()
    {
        //un guerrier en mode Berserk ne rate jamais son coup, de plus, 2% des points Berserk du Guerrier viennent s'ajouter à son attaque.
        //Toujours en mode berserk, l'attaque du guerrier oscille entre son attribu power et 50% au lieu de attribut power et 20%
        if($this->getEtatBerserk()>=5)
        {
            $dmg=rand(($this->getberserkPMax()*50)/100, $this->getberserkPMax());
            $dmg+=($this->getberserkP()*2)/100;
            $this->updateBerserk($dmg,false);
            echo("<p style='color:#d32f2f;'>".$this->getName()." est en mode Berserk. (".$this->getberserkP()."/".$this->getberserkPMax().")</p>");
            return round($dmg);
        }
        else
        {
            //un gerrier hors mode berserk peut rater.
            $chance=rand(1,5);
            if($chance==1)
            {
                echo("<p style='color:#CFD8DC;'>".$this->getName()." loupe sa cible.</p>");
                return 0;
            }
            else
            {
                $dmg=rand((20*$this->getberserkPMax())/100, $this->getberserkPMax());
                $this->updateBerserk($dmg,false);
                echo("<p style='color:#CFD8DC;'>".$this->getName()." attaque sa cible.(".$this->getberserkP()."/".$this->getberserkPMax().")</p>");
                return round($dmg);
            }
        }
    }
}
?>