import { Component } from '@angular/core';
import { Container } from '../../shared/container/container';
import { RouterLink } from '@angular/router';

@Component({
  imports: [Container, RouterLink],
  selector: 'app-home',
  styleUrl: './home.css',
  templateUrl: './home.html',
})
export class Home {}
