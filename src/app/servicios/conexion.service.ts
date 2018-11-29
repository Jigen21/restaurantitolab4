import { Injectable } from '@angular/core';

import { Cliente } from "../clases/cliente";
import { Auto } from '../clases/auto';
import { Turno } from '../clases/turno';

import { HttpClient, HttpHeaders } from '@angular/common/http';

//const config = { "headers": new HttpHeaders({ "token": localStorage.getItem("token") }) };
const config = { "headers": new HttpHeaders({ 
  'Content-Type':'application/x-www-form-urlencoded'
}) 
};

@Injectable({
  providedIn: 'root'
})
export class ConexionService {

  constructor(private http: HttpClient) { }

  public Registrar(cliente: Cliente) { return this.http.post("http://192.168.2.42:3003/clientes", { "cliente": cliente }); }
 // public Logear(correo: string, password: string) { return this.http.post("http://192.168.2.42:3003/login", { "cliente": { "user": correo, "pass": password } }); }
  public AltaAuto(auto: Auto) { return this.http.post("http://192.168.2.42:3003/auto", { "auto": auto }, config); }
  public PedirTurno(turno: Turno) { return this.http.post("http://192.168.2.42:3003/turnos", { "turno": turno }, config); }
  public ObtenerTurnos() { return this.http.get("http://192.168.2.42:3003/turnos", config); }
  public ObtenerClientes() { return this.http.get("http://192.168.2.42:3003/clientes", config); }
  public ObtenerAutos() { return this.http.get("http://192.168.2.42:3003/auto", config); }



  public Logear(correo: string, password: string) 
  {
    let params='correo='+correo+'&clave='+password;


    return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/login",params, config);
    //return this.http.post("assets/api/login",params, config);

    }


    public Pedidos()
    {
      return this.http.get("https://restaurantequinteros.000webhostapp.com/assets/api/productos/",config);

    }

    public Mesas()
    {
      return this.http.get("https://restaurantequinteros.000webhostapp.com/assets/api/mesas/",config);
    }

    public OcuparMesa(id,correo)
    {
      let params='id='+id+'&correo='+correo;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/ocuparMesa/",params,config);
    }

    public Pedir(nombre,tipo,precio,tiempo,cantidad,correo)
    {

      let params='nombre='+nombre+'&tipo='+tipo+'&precio='+precio+'&tiempo='+tiempo+'&cantidad='+cantidad+'&correo='+correo;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/guardarProductos/",params,config);

    }

    public verPedidos(tipo)
    {
      let params='tipo='+tipo;
      

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/verPedidos/",params,config);
    }

    public terminarPedido(numeroMesa,tipo)
    {
      let params='id='+numeroMesa+'&tipo='+tipo;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/terminarPedido/",params,config);
    }

    public estoySentado(nombre)
    {
      let params='nombre='+nombre;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/estoySentado/",params,config);
    }

    public entregarPedido(id)
    {
      let params='id='+id;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/entregarPedido/",params,config);
    }

    public traerEmpleados()
    {
      return this.http.get("https://restaurantequinteros.000webhostapp.com/assets/api/traerEmpleados/",config);
    }

    public Alta(correo,tipo,password)
    {
      let params='correo='+correo+'&tipo='+tipo+'&password='+password;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/alta/",params,config);

    }

    public Tomado(id)
    {
      let params='id='+id;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/tomado/",params,config);

    }

    public traerTotal(nombre)
    {
      let params='nombre='+nombre;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/traerTotal/",params,config);

    }

    public registrarCliente(nombre,tipo,password)
    {
      let params='correo='+nombre+'&tipo='+tipo+'&password='+password;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/registrarCliente/",params,config);

    }

    public pagar(nombre)
    {
      let params='nombre='+nombre;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/pagar/",params,config);

    }

    public liberarMesa(id)
    {
      let params='id='+id;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/liberarMesa/",params,config);

    }


    public estadoPedido(nombre)
    {
      let params='nombre='+nombre;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/estadoPedido/",params,config);

    }

    public eliminarEmpleado(nombre)
    {
      let params='nombre='+nombre;

      return this.http.post("https://restaurantequinteros.000webhostapp.com/assets/api/eliminarEmpleado/",params,config);

    }


    public traerFechas()
    {
      

      return this.http.get("https://restaurantequinteros.000webhostapp.com/assets/api/traerFechas/",config);

    }

    public traerOperaciones()
    {
     

      return this.http.get("https://restaurantequinteros.000webhostapp.com/assets/api/traerOperaciones/",config);

    }











}