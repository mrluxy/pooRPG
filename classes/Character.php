<?php
 abstract class Character
{
    //Attributs
    protected $_name;
    protected $_health;
    protected $_maxHealth;
    protected $_armor;

//Constructeur

    public function __construct($name, $maxHealth, $armor)
    {
        $this->setName($name);
        $this->setHealth($maxHealth);
        $this->setMaxHealth($maxHealth);
        $this->setArmor($armor);
    }
//les getter

    public function getName()
    {
        return($this->_name);
    }
    public function getHealth()
    {
        return($this->_health);
    }
    public function getMaxHealth()
    {
        return($this->_maxHealth);
    }
    public function getArmor()
    {
        return($this->_armor);
    }

    public function getNameHUD()
    {
        return("<b style='color:#A5D6A7'>".$this->_name."</b>");
    }
    public function getHealthHUD()
    {
        return("<b style='color:#e57373'>".$this->_health."</b>");
    }
    public function getMaxHealthHUD()
    {
        return("<b style='color:#f44336'>".$this->_maxHealth."</b>");
    }
    public function getArmorHUD()
    {
        return("<b style='color:#80DEEA'>".$this->_armor."</b>");
    }
    
//les setter
    public function setName($val)
    {
        $this->_name=$val;
    }
    public function setHealth($val)
    {
        $this->_health=$val;
    }
    public function setMaxHealth($val)
    {
        $this->_maxHealth=$val;
    }
    
    public function setArmor($val)
    {
        $this->_armor=$val;
    }
    public function setPower($val)
    {
        $this->_power=$val;
    }
    public function setWeapon($val)
    {
        $this->_weapon=$val;
    }
    public function setSpeed($val)
    {
        $this->_speed=$val;
    }

    //le reste
    public function getAll()
    {
        return "";
    }
    public function getHit($dmg)
    {
        return 0;
    }
    public function hit()
    {
        return 0;
    }
}


?>