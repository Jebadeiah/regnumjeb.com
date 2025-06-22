function Creature(abilities, avatar, combat_class, dialogue, effects, inventory, level, medals, passives, permed_billies, quests, species, stats) {
    this.abilities = abilities;
    this.avatar = avatar;
    this.combat_class = combat_class;
    this.dialogue = dialogue;
    this.effects = effects;
    this.inventory = inventory;
    this.level = level;
    this.medals = medals;
    this.passives = passives;
    this.permed_billies = this.permed_billies;
    this.quests = quests;
    this.species = species;
    this.stats = stats;
}













class Creature {
    constructor(abilities, avatar, combat_class, dialogue, effects, inventory, level, medals, passives, permed_billies, quests, species, stats){
        this.abilities = abilities;
        this.avatar = avatar;
        this.combat_class = combat_class;
        this.dialogue = dialogue;
        this.effects = effects;
        this.inventory = inventory;
        this.level = level;
        this.medals = medals;
        this.passives = passives;
        this.permed_billies = this.permed_billies;
        this.quests = quests;
        this.species = species;
        this.stats = stats;

    class playerCharacter extends Creature(){
        constructor() {
            super(abilities, avatar, combat_class, dialogue, effects, inventory, level, medals, passives, permed_billies, quests, species, stats);    
}
}
}
}