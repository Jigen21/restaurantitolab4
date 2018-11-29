import { NgModule }                 from '@angular/core';
import { CommonModule }             from '@angular/common';
import { Routes, RouterModule }     from '@angular/router';

import { AutorizacionService }      from "../../servicios/autorizacion.service";
import { VerificarTipoService }     from "../../servicios/verificar-tipo.service";

import { LoginComponent }           from "../../componentes/login/login.component";
import { RegistroComponent }        from "../../componentes/registro/registro.component";
import { PrincipalComponent }       from "../../componentes/principal/principal.component";
import { CargarAutoComponent }      from "../../componentes/cargar-auto/cargar-auto.component";
import { PedirTurnoComponent }      from "../../componentes/pedir-turno/pedir-turno.component";
import { MostrarTurnosComponent }   from "../../componentes/mostrar-turnos/mostrar-turnos.component";
import { TodosLosTurnosComponent }  from '../../componentes/todos-los-turnos/todos-los-turnos.component';
import { PageNotFoundComponent }    from "../../componentes/page-not-found/page-not-found.component";
import { HacerPedidoComponent } from '../../componentes/hacer-pedido/hacer-pedido.component';
import { VerMesasComponent } from '../../componentes/ver-mesas/ver-mesas.component';
import { VerPedidosComponent } from '../../componentes/ver-pedidos/ver-pedidos.component';
import { EstadoPedidoComponent } from '../../componentes/estado-pedido/estado-pedido.component';
import { AdministrarComponent } from '../../componentes/administrar/administrar.component';
import { PagarComponent } from '../../componentes/pagar/pagar.component';

const rutas: Routes = [
  { path: "", component: LoginComponent },
  { path: "registro", component: RegistroComponent },
  { path: "principal", component: PrincipalComponent, children:[

    { path: "pedir", component: HacerPedidoComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["admin", "cliente","mozo"]} },
    { path: "mesas", component: VerMesasComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["admin", "cliente","mozo"]} },
    { path: "pedidos", component: VerPedidosComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["admin", "cliente","mozo","cocinero","bartender","candybar","cervezero"]} },
    { path: "estadoPedido", component: EstadoPedidoComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["admin", "cliente","mozo","cocinero"]} },
    { path: "administrar", component: AdministrarComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["supervisor"]} },
    { path: "pagar", component: PagarComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["cliente"]} },
   ]},
 /* { path: "principal", component: PrincipalComponent, canActivate: [AutorizacionService], children:[
    { path: "auto", component: CargarAutoComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["admin", "cliente"]} },
    { path: "turno", component: PedirTurnoComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["admin", "cliente"]} },
    { path: "turnos", component: MostrarTurnosComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["cliente"]} },
    { path: "todos-los-turnos", component: TodosLosTurnosComponent, canActivate: [AutorizacionService, VerificarTipoService], data: {roles: ["admin"]} }
  ] },*/
  { path: "**", component: PageNotFoundComponent }
 ];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(rutas)
  ],
  exports: [RouterModule],
  declarations: []
})
export class RutasModule { }
