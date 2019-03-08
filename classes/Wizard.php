<?php
//est une sous classe de Character
class Wizard extends Character
{
    //Attributs
    protected $_mana;
    protected $_maxMana;
    protected $_element;
    protected $_barrier;
    protected $_castLevel;

    public function __construct($name, $maxHealth, $armor, $maxMana, $element)
    {
        parent::__construct($name, $maxHealth, $armor);
        $this->setMaxMana($maxMana);
        $this->setMana($maxMana);
        switch ($element) {
            case '1':
                $this->setElement('Fire');
                break;
            case '2':
                $this->setElement('Earth');
                break;
            case '3':
                $this->setElement('Water');
                break;
            case '4':
                $this->setElement('Air');
                break;
            
            default:
                $this->setElement('Void');
                break;
        }
        $this->setBarrier(true);
    }
    
    //Get
    public function getMana()
    {
        return($this->_mana);
    }
    public function getMaxMana()
    {
        return($this->_maxMana);
    }
    public function getElement()
    {
        return($this->_element);
    }
    public function getBarrier()
    {
        return $this->_barrier;
    }
    public function getCastLevel()
    {
        return $this->_castLevel;
    }

    //Set
    public function setMana($val)
    {
        $this->_mana = $val;
        if($this->_mana>$this->_maxMana)
        {
            $this->_mana = $this->_maxMana;
        }
    }
    public function setMaxMana($val)
    {
        $this->_maxMana = $val;
    }
    public function setElement($val)
    {
        $this->_element = $val;
    }
    public function setBarrier($_barrier)
    {
        $this->_barrier = $_barrier;
    }
    public function setCastLevel($val)
    {
        $this->_castLevel = $val;
    }

    //getHUD

    public function getManaHUD()
    {
        return("<b style='color=#64B5F6;'>".$this->_mana."</b>");
    }
    public function getMaxManaHUD()
    {
        return("<b style='color=#2196F3;'>".$this->_maxMana."</b>");
        
    }
    public function getElementHUD()
    {
        return("<b style='color=#B3E5FC;'>".$this->_element."</b>");
    }

    //Méthodes
    public function getAll()
    {
        echo("<p>".$this->getNameHUD()." est un sorcier de type ".$this->getElementHUD().", il possède ".$this->getHealthHUD()."/".$this->getMaxHealthHUD()." PV, ".$this->getManaHUD()."/".$this->getMaxMana()." points de mana et ".$this->getArmorHUD()." points d'armure.");
    }
    public function getHit($dmg)
    {
        if($dmg>0)
        {
            //Le mage possède un barrière très forte mais ne peut ni esquiver, ni parer.
            if($this->getBarrier()==true)
            {
                
                $this->setBarrier(false);
                echo("<p style='color:#FFD54F;'>Un lourd impact viens frapper la barrière de ".$this->getName()." qui éxplose en éclats. (".$dmg.")</p>");
                $dmg=0;
            }
            else
            {
                $dmg -= $this->getArmor();
                $this->setHealth($this->getHealth()-$dmg);
                echo("<p style='color:#e57373;'>".$this->getName()." se prend l'attaque de plein fouet et prend <b style='color:red;'>".$dmg."</b> points de dégats ! <b style='color:red;'>(PV:".$this->getHealth()."/".$this->getMaxHealth().")</b></p>");
            }
        }
    }
    public function castBarrier()
    {
        if($this->getBarrier()==false && $this->getMana()>=5)
        {
            $this->setMana($this->getMana()-5);
            $this->setBarrier(true);
            echo("<p style='color:#FFF176;'>".$this->getName()." invoque une barrière de protection. (Mana : ".$this->_mana."/".$this->_maxMana.")</p>");
        }
        else
        {
            $this->setMana($this->getMana()+15);
            echo("<p style='color:#4DD0E1;'>".$this->getName()." se charge en mana. (Mana : ".$this->_mana."/".$this->_maxMana.")</p>");
        }
    }
    public function castSpell()
    {
        if($this->getMana()>=20)
        {
            $this->setMana($this->getMana()-20);
            $dmg=rand(350,700);
            $this->setCastLevel(0);
            echo("<p style='color:#DCEDC8;'>".$this->getName()." lance un sort ! (Mana : ".$this->_mana."/".$this->_maxMana.")</p>");
            return $dmg;
        }
        else
        {
            $this->setMana($this->getMana()+15);
            echo("<p style='color:#4DD0E1;'>".$this->getName()." se charge en mana. (Mana : ".$this->_mana."/".$this->_maxMana.")</p>");
        }
    }
    public function hit()
    {
        $action=rand(1,10);
        switch ($action) {
            case '1':
                $this->castBarrier();
                return 0;
                break;
            case '2':
                $this->castBarrier();
                return 0;
                break;
            case '3':
                $dmg=rand(350,700);
                $this->setCastLevel(2);
                echo("<p style='color:#81C784;'>".$this->getName()." se concentre et lance un sort instantané !</p>");
                return $dmg;
            
            default:
                if($this->getCastLevel()>=2)
                {
                    $dmg=$this->castSpell();
                    return $dmg;
                }
                else
                {
                    if($this->getCastLevel()==0)
                    {
                        $this->setCastLevel($this->getCastLevel()+1);
                        echo("<p style='color:#CFD8DC;'>".$this->getName()." commence une incantation.</p>");
                        return 0;
                    }
                    else
                    {
                        $this->setCastLevel($this->getCastLevel()+1);
                        echo("<p style='color:#CFD8DC;'>".$this->getName()." termine son incantation.</p>");
                        return 0;
                    }
                }
                break;
        }
    }
    
}
?>