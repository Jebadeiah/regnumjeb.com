class Avatar {
    constructor(
        name,
        gender,
        def_skin,
        strength,
        dexterity,
        constitution,
        intelligence,
        wisdom,
        charisma,
        health,
        magic,
        armor,
        attack,
        mysticism
    ) {
        this.name =         name;
        this.gender =       gender;
        this.def_skin =     def_skin;
        this.strength =     strength;
        this.dexterity =    dexterity;
        this.constitution = constitution;
        this.intelligence = intelligence;
        this.wisdom =       wisdom;
        this.charisma =     charisma;
        this.health =       health;
        this.magic =        magic;
        this.armor =        armor;
        this.attack =       attack;
        this.mysticism =    mysticism;
        this.birth_date =   new Date();
    };
    age() {
    let now = new Date();
    let birth = new Date(this.birth_date);
    let elapsed = now - birth;
    let daysSinceBorn = Math.floor(elapsed / (1000 * 3600 * 24));
    return daysSinceBorn;
    }
}