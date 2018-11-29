export class Auto {

    public patente: string;
    public marca: string;
    public color: string;
    public kilometros: number;
    public tipo: string;
    public correo: string;

    constructor(patente: string, marca: string, color: string, kilometros: number, tipo: string, correo: string) {

        this.patente = patente;
        this.marca = marca;
        this.color = color;
        this.kilometros = kilometros;
        this.tipo = tipo;
        this.correo = correo;
    }
}
