export class Turno {

    public correo: string;
    public fecha: string;
    public estado: number;

    constructor(correo: string, fecha: string, estado: number) {

        this.correo = correo;
        this.fecha = fecha;
        this.estado = estado;
    }
}
