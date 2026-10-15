import { Component, signal } from '@angular/core';
import { Container } from '../../shared/container/container';
import { MOCK_PRODUCTS } from '../../mock/products.mock';
import { RouterLink } from '@angular/router';

@Component({
  imports: [Container, RouterLink],
  selector: 'app-products',
  styleUrl: './products.css',
  templateUrl: './products.html',
})
export class Products {
  products = signal(MOCK_PRODUCTS);
}
