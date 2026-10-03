import type { GenericAbortSignal } from "axios";
import type { TestimonialFormValuesType } from "../schema/testimonial";
import axios from "@/utils/axios";
import type { TestimonialType, PaginationType } from "@/utils/types";
import { api_routes } from "@/utils/routes/api_routes";


export const createTestimonialHandler = async (val: TestimonialFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: TestimonialType }>(api_routes.testimonial.create, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const updateTestimonialHandler = async (id: number, val: TestimonialFormValuesType, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.post<{ data: TestimonialType }>(api_routes.testimonial.update + `/${id}`, { ...val, is_active: val.is_active ? 1 : 0 }, { signal, headers: { "Content-Type": "multipart/form-data" } });
    return response.data.data;
}


export const deleteTestimonialHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.delete<{ data: TestimonialType }>(api_routes.testimonial.delete + `/${id}`, { signal });
    return response.data.data;
}


export const toggleTestimonialStatusHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: TestimonialType }>(api_routes.testimonial.toggle_status + `/${id}`, { signal });
    return response.data.data;
}


export const getTestimonialHandler = async (id: number, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<{ data: TestimonialType }>(api_routes.testimonial.view + `/${id}`, { signal });
    return response.data.data;
}

export const getTestimonialsHandler = async (params: URLSearchParams, signal?: GenericAbortSignal | undefined) => {
    const response = await axios.get<PaginationType<TestimonialType>>(api_routes.testimonial.paginate, { params, signal });
    return response.data;
}