/**
 * localStorage wrapper for goal persistence
 * Handles reading, saving, and clearing goals from browser storage
 */

import { Goal } from "@/types/goal";

const STORAGE_KEY = "doit_goals";

/**
 * Load goals from localStorage
 * @returns Array of goals, or empty array if none exist or error occurs
 */
export function loadGoals(): Goal[] {
  try {
    // Only access localStorage in browser environment
    if (typeof window === "undefined") {
      return [];
    }

    const stored = window.localStorage.getItem(STORAGE_KEY);
    if (!stored) {
      return [];
    }

    return JSON.parse(stored) as Goal[];
  } catch (error) {
    console.error("Failed to load goals from localStorage:", error);
    return [];
  }
}

/**
 * Save goals to localStorage
 * @param goals - Array of goals to persist
 */
export function saveGoals(goals: Goal[]): void {
  try {
    // Only access localStorage in browser environment
    if (typeof window === "undefined") {
      return;
    }

    window.localStorage.setItem(STORAGE_KEY, JSON.stringify(goals));
  } catch (error) {
    console.error("Failed to save goals to localStorage:", error);
  }
}

/**
 * Clear all goals from localStorage
 */
export function clearGoals(): void {
  try {
    if (typeof window === "undefined") {
      return;
    }

    window.localStorage.removeItem(STORAGE_KEY);
  } catch (error) {
    console.error("Failed to clear goals from localStorage:", error);
  }
}
